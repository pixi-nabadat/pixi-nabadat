<?php

namespace App\Services;

use App\Enum\PaymentMethodEnum;
use App\Enum\PaymentStatusEnum;
use App\Enum\UserPackageStatusEnum;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Api\BuyCustomPulsesController;
use App\Models\Center;
use App\Models\Invoice;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserPackage;
use App\QueryFilters\UserPackagesFilter;
use Illuminate\Database\Eloquent\Builder;

class UserPackageService extends BaseService
{

    public function listing(array $filters = [], array $withRelation = []): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        $perPage = config('app.perPage');
        return $this->queryGet(where_condition: $filters, withRelation: $withRelation)->cursorPaginate($perPage);
    }

    public function queryGet(array $where_condition = [], $withRelation = []): Builder
    {
        $userPackages = UserPackage::query()->with($withRelation);
        return $userPackages->filter(new UserPackagesFilter($where_condition));
    }

    /**
     * @throws NotFoundException
     */
    public function update(int $id, array $data=[]): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|Builder|array
    {
        $userPackage = $this->find(id:$id,with:['user','package'] );
        if (!$userPackage)
            throw new NotFoundException(trans("lang.offers_not_found_or_package_paid"));
        if($userPackage->payment_status == PaymentStatusEnum::PAID)
            throw new NotFoundException(trans("lang.package_is_paid"));
        $ongoingPackage = $userPackage->user->package->where('status', UserPackageStatusEnum::ONGOING)->first();
        if(!$ongoingPackage)
            $data['status'] = $data['payment_status'] == PaymentStatusEnum::PAID ? UserPackageStatusEnum::ONGOING: UserPackageStatusEnum::PENDING;
        else
            $data['status'] = $data['payment_status'] == PaymentStatusEnum::PAID ? UserPackageStatusEnum::READYFORUSE: UserPackageStatusEnum::PENDING;
        $data['remain'] = $data['num_nabadat'];
        $is_updated =  $userPackage->update($data);
        $userPackage->refresh();
        $user = $userPackage->user;
        if($data['payment_status'] == PaymentStatusEnum::PAID)
        {
            $this->increaseUserWallet(user: $user, pulses: $data['num_nabadat']);
            $this->createTransaction(center: $userPackage->center, user: $user, pulsesCount: $data['num_nabadat'], packageId: $userPackage->package_id);
        }
        return $userPackage;
    }

    public function create(array $data =[]){
        return UserPackage::create($data);
    }

    public function store(array $data)
    {
        $user = User::find($data['user_id']);
        if(!$user)
            throw new NotFoundException(trans('lang.user_not_found'));
        $userPackages = $user->package->where('status', UserPackageStatusEnum::ONGOING)->first();
        if(!$userPackages)
            $data['status'] = $data['payment_status'] == PaymentStatusEnum::PAID ? UserPackageStatusEnum::ONGOING: UserPackageStatusEnum::PENDING;
        else
            $data['status'] = $data['payment_status'] == PaymentStatusEnum::PAID ? UserPackageStatusEnum::READYFORUSE: UserPackageStatusEnum::PENDING;
        $data['remain'] = $data['num_nabadat'];
        $userPackage = UserPackage::create($data);
        if($data['payment_status'] == PaymentStatusEnum::PAID)
        {
            $this->increaseUserWallet(user: $user, pulses: $data['num_nabadat']);
            $this->createTransaction(center: $userPackage->center, user: $user, pulsesCount: $data['num_nabadat'], packageId: $userPackage->package_id);
        }
        /**
         * TODO
         * add user package financial code here
         */
        return  $userPackage;
    }


    /**
     * @throws NotFoundException
     */
    public function find(int $id, array $with = []): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|bool|Builder|array
    {
        $userPackage = UserPackage::with($with)->find($id);
        if (!$userPackage)
            throw new NotFoundException(trans('user package not found'));
        return $userPackage;
    }

    public function delete(int $id)
    {
        $userPackage = $this->find($id);
        if(!$userPackage)
            throw new NotFoundException(trans('lang.user_package_not_found'));
        $paymentStatus = $userPackage->payment_status;
        if($paymentStatus != PaymentStatusEnum::UNPAID)
            throw new NotFoundException(trans('lang.not_allowed'));
        return $userPackage->delete();

    } //end of delete

    public function decreaseFromOffer(User $user, Center $center, int $number_of_pulses)
    {
        if ($number_of_pulses == 0)
            return true ;
        $activeUserPackage = $user->package->where('status',UserPackageStatusEnum::ONGOING)->where('payment_status',PaymentStatusEnum::PAID)->where('remain','!=',0)->first();
        if ($activeUserPackage)
        {
            if ($number_of_pulses > $activeUserPackage->remain)
            {

                $remain_pulses = $number_of_pulses - $activeUserPackage->remain;
                $activeUserPackage->used = $activeUserPackage->used + $activeUserPackage->remain;
                $activeUserPackage->remain = 0;
                $activeUserPackage->status = UserPackageStatusEnum::COMPLETED;
                $this->getNextReadyUserPackage(user: $user);
                $activeUserPackage->save();
                $activeUserPackage->refresh();

                //start update user wallet
                $this->decreaseUserWallet(user: $user, pulses: $activeUserPackage->remain);
                //end update user wallet
                
                $this->decreaseFromOffer(user: $user, center: $center, number_of_pulses: $remain_pulses);
            }else{
                $old_remain = $activeUserPackage->remain ;
                $activeUserPackage->remain = $old_remain - $number_of_pulses ;
                $activeUserPackage->used = $activeUserPackage->used + $number_of_pulses ;
                if ($old_remain - $number_of_pulses == 0)
                {
                    $activeUserPackage->status = UserPackageStatusEnum::COMPLETED ;
                    $this->getNextReadyUserPackage(user: $user);
                }
                $activeUserPackage->save();
                $activeUserPackage->refresh();

                //start update user wallet
                $this->decreaseUserWallet(user: $user, pulses: $number_of_pulses);
                //end update user wallet
                return true;
            }
        }else{
            //there is no userpackage and number_of_pulses != 0
            //start create transaction
            $userPackageData = app()->make(BuyCustomPulsesController::class)->getUserPackageDataForCustomPulses(num_nabadat: $number_of_pulses, center: $center, user: $user, payment_status: PaymentStatusEnum::UNPAID, payment_method: PaymentMethodEnum::CASH);
            $user_package = $this->store($userPackageData);
            $this->createTransaction(center: $center, user: $user, pulsesCount: $number_of_pulses);

            //end create transaction

        }
    }


    /**
     * get the next ready userPackage and convert it to ONGOING
     * @param User $user
     * @return bool
     */
    private function getNextReadyUserPackage(User $user): bool
    {
        $readyUserPackage =  $user->package->where('status',UserPackageStatusEnum::READYFORUSE)->where('payment_status',PaymentStatusEnum::PAID)->first();
        
        if(!$readyUserPackage)
            return false;

        $readyUserPackage->update([
            'status'=>UserPackageStatusEnum::ONGOING,
        ]);

        return true;
    }

    /**
     * get the user wallet and increase it
     * @param User $user
     * @param int $pulses
     * @return bool
     */
    private function increaseUserWallet(User $user, int $pulses): bool
    {
        $userWallet = $user->nabadatWallet;
        $userWallet->total_pulses = $userWallet->total_pulses + $pulses;
        $userWallet->save();
        return true;
    }

    /**
     * get the user wallet and decrease it
     * @param User $user
     * @param int $pulses
     * @return bool
     */
    private function decreaseUserWallet(User $user, int $pulses): bool
    {
        $userWallet = $user->nabadatWallet;
        $userWallet->total_pulses = $userWallet->total_pulses - $pulses;
        $userWallet->used_amount = $userWallet->used_amount + $pulses;
        $userWallet->save();
        return true;
    }

    private function createTransaction(Center $center, User $user, int $pulsesCount, int $packageId = null)
    {
        $centerInvoice = $center->invoices()->where('status', Invoice::PENDING)->first();
        $center_dues = $pulsesCount - ($pulsesCount * ($center->app_discount/100));
        $nabadat_app_dues = $pulsesCount - ($pulsesCount - ($pulsesCount * ($center->app_discount/100)));
        $transactionData = [
            'invoice_id'=>$centerInvoice->id,
            'user_id'=>$user->id,
            'package_id'=>$packageId,
            'num_pulses'=>$pulsesCount,
            'center_dues'=>$center_dues,
            'nabadat_app_dues'=>$nabadat_app_dues,
            'original_price'=>0,
            'center_discount'=>0,
            'user_discount'=>0,
        ];
        Transaction::create($transactionData);
        $centerInvoice->update([
            'total_center_dues'=>$centerInvoice->total_center_dues + $center_dues,
            'total_nabadat_dues'=>$centerInvoice->total_nabadat_dues + $nabadat_app_dues,
        ]);
    }
}
