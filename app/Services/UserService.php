<?php

namespace App\Services;

use App\Enum\ImageTypeEnum;
use App\Enum\PaymentMethodEnum;
use App\Enum\PaymentStatusEnum;
use App\Enum\UserPackageStatusEnum;
use App\Exceptions\NotFoundException;
use App\Models\Center;
use App\Models\Invoice;
use App\Models\User;
use App\QueryFilters\UsersFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class UserService extends BaseService
{

    public function getAll(array $where_condition = [],$withRelations=[]): \Illuminate\Database\Eloquent\Collection|array
    {
        $users = $this->queryGet($where_condition,$withRelations);
        return $users->get();
    }

    public function queryGet(array $where_condition = [],$withRelation=[]): Builder
    {
        $users = User::query()->with($withRelation);
        return $users->filter(new UsersFilter($where_condition));
    }

    public function store($data)
    {

        $data['password'] = bcrypt($data['password']);
        $data['date_of_birth'] = isset($data['date_of_birth']) ? Carbon::parse($data['date_of_birth']) : null;
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $user = User::create($data);
        if (isset($data['logo']))
        {
            $fileData = FileService::saveImage(file: $data['logo'],path: 'uploads\users', field_name: 'logo');
            $fileData['type'] = ImageTypeEnum::LOGO;
            $user->storeAttachment($fileData);
        }
        return $user;

    } //end of create

    public function changeStatus($id)
    {
        $user = $this->find($id);
        $user->is_active = !$user->is_active;
        $user->save();
    }

    public function find($id, $withRelations = []): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|Builder|bool|array
    {
        $user = User::with($withRelations)->find($id);
        if ($user)
            return $user;
        return false;
    }//end of changeStatus

    public function delete($id)
    {
        $user = $this->find($id);
        if ($user)
        {
            $user->deleteAttachments();
            return $user->delete();
        }
        return false;
    }//end of delete

    public function update($id, $data)
    {
        $data['password'] = bcrypt($data['password']);
        $data['date_of_birth'] = Carbon::parse($data['date_of_birth']);
        isset($data['is_active']) ? $data['is_active'] = 1 : $data['is_active'] = 0;


        $user = User::find($id);
        if (!$user)
            return false;
        if (isset($data['logo']))
        {
            $user->deleteAttachmentsLogo();
            $fileData = FileService::saveImage(file: $data['logo'],path: 'uploads\users', field_name: 'logo');
            $fileData['type'] = ImageTypeEnum::LOGO;
            $user->storeAttachment($fileData);
        }
        $user->update($data);
    }//end of update

    public function updateOrCreateNabadatWallet(User $user, $package,$payment_method=PaymentMethodEnum::CASH,$payment_status =PaymentStatusEnum::UNPAID): bool
    {
        if (!$user)
            return false;
        $old_pulses = $user->nabadatWallet->total_pulses ?? 0;
        $total_pulses = $old_pulses + $package->num_nabadat;
        //check if user has in progress offer
        $active_user_package = $user->package()->where('status',UserPackageStatusEnum::ONGOING)->where('payment_status',PaymentStatusEnum::PAID)->count();
        $user_package_data = [
            'package_id'            => $package->id,
            'num_nabadat'           => $package->num_nabadat,
            'price'                 => $package->price,
            'center_id'             => $package->center_id,
            'discount_percentage'   => $package->discount_percentage,
            'payment_method'        => $payment_method,
            'payment_status'        => $payment_status,
            'status'                => $active_user_package > 0 ? UserPackageStatusEnum::PENDING : UserPackageStatusEnum::ONGOING,
            'used_amount'           =>0,
            'remain'                =>$package->num_nabadat
        ];
        $user_package = $user->package()->create($user_package_data);
        if ($user_package && $user_package->payment_status == PaymentStatusEnum::PAID){
            $user->nabadatWallet()->updateOrCreate(['user_id'=>$user->id],['total_pulses' => $total_pulses]);
        }
        return true;
    }

    public function updateOrCreateNabadatWalletForCustomPulses(User $user, Center $center, int $numNabadat, $payment_method=PaymentMethodEnum::CASH,$payment_status =PaymentStatusEnum::UNPAID): bool
    {
        if (!$user)
            return false;
        $old_pulses = $user->nabadatWallet->total_pulses ?? 0;
        $total_pulses = $old_pulses + $numNabadat;
        //check if user has in progress offer
        $active_user_package = $user->package()->where('status',UserPackageStatusEnum::ONGOING)->where('payment_status',PaymentStatusEnum::PAID)->count();
        $user_package_data = [
            'num_nabadat'           => $numNabadat,
            'price'                 => $center->PulsePriceAfterDiscount * $numNabadat,
            'center_id'             => $center->id,
            'discount_percentage'   => $center->pulse_discount,
            'payment_method'        => $payment_method,
            'payment_status'        => $payment_status,
            'status'                => $active_user_package > 0 ? UserPackageStatusEnum::PENDING : UserPackageStatusEnum::ONGOING,
            'used_amount'           =>0,
            'remain'                =>$numNabadat
        ];
        $user_package = $user->package()->create($user_package_data);
        if ($user_package && $user_package->payment_status == PaymentStatusEnum::PAID){
            $user->nabadatWallet()->updateOrCreate(['user_id'=>$user->id],['total_pulses' => $total_pulses]);
        }
        return true;
    }


    public function status($id)
    {
        $user = $this->find($id);
        $user->is_active = !$user->is_active;
        return $user->save();
    }//end of status

    public function getAuthUser()
    {
        $user =auth()->user();
        if (!$user)
            throw new NotFoundException(trans('lang.user_not_found'));
        else
            return $user;

    }
}
