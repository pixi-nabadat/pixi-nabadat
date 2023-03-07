<?php

namespace App\Services;

use App\Enum\PaymentStatusEnum;
use App\Enum\UserPackageStatusEnum;
use App\Exceptions\NotFoundException;
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
    public function update(int $id, array $data): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|Builder|array
    {
        $userPackage = $this->find(id:$id,with:['user','package'] );
        if (!$userPackage)
            throw new NotFoundException(trans('lang.offers_not_found'));
      $userPackage->update([
            'payment_status' => $data['payment_status'],
        ]);
     return  $userPackage->refresh();
    }

    public function create(array $data =[]){
        return UserPackage::create($data);
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
        return $userPackage->delete();

    } //end of delete

    public static function decreaseFromOffer(User $user, Center $center, int $number_of_pulses)
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
                self::getNextReadyUserPackage(user: $user);
                $activeUserPackage->save();
                $activeUserPackage->refresh();

                //start update user wallet
                self::updateUserWallet(user: $user, usedPulses: $activeUserPackage->remain);
                //end update user wallet
                
                self::decreaseFromOffer(user: $user, center: $center, number_of_pulses: $remain_pulses);
            }else{
                $old_remain = $activeUserPackage->remain ;
                $activeUserPackage->remain = $old_remain - $number_of_pulses ;
                $activeUserPackage->used = $activeUserPackage->used + $number_of_pulses ;
                if ($old_remain - $number_of_pulses == 0)
                {
                    $activeUserPackage->status = UserPackageStatusEnum::COMPLETED ;
                    self::getNextReadyUserPackage(user: $user);
                }
                $activeUserPackage->save();
                $activeUserPackage->refresh();

                //start update user wallet
                self::updateUserWallet(user: $user, usedPulses: $number_of_pulses);
                //end update user wallet
                return true;
            }
        }else{
            //there is no userpackage and number_of_pulses != 0
            //start create transaction
            self::createTransaction(center: $center, user: $user, pulsesCount: $number_of_pulses);
            //end create transaction

        }
    }


    /**
     * get the next ready userPackage and convert it to ONGOING
     * @param User $user
     * @return bool
     */
    private static function getNextReadyUserPackage(User $user): bool
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
     * get the user wallet and update it
     * @param User $user
     * @param int $usedPulses
     * @return bool
     */
    private static function updateUserWallet(User $user, int $usedPulses): bool
    {
        $userWallet = $user->nabadatWallet;
        $userWallet->total_pulses = $userWallet->total_pulses - $usedPulses;
        $userWallet->used_amount = $userWallet->used_amount + $usedPulses;
        $userWallet->save();
        return true;
    }    

    private static function createTransaction(Center $center, $user, $pulsesCount)
    {
        $centerInvoice = $center->invoices()->where('status', Invoice::PENDING)->first();
        $center_dues = $pulsesCount - ($pulsesCount * ($center->app_discount/100));
        $nabadat_app_dues = $pulsesCount - ($pulsesCount - ($pulsesCount * ($center->app_discount/100)));
        $transactionData = [
            'invoice_id'=>$centerInvoice->id,
            'user_id'=>$user->id,
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
