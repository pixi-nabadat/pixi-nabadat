<?php

namespace App\Services;

use App\Models\Center;
use App\Models\Order;
use App\Models\User;
use App\QueryFilters\UsersFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class UserService extends BaseService
{

    public function getAll(array $where_condition = [])
    {
        $users = $this->queryGet($where_condition);
        return $users->get();
    }

    public function queryGet(array $where_condition = []): Builder
    {
        $users = User::query();
        return $users->filter(new UsersFilter($where_condition));
    }

    public function store($data)
    {

        $data['password'] = bcrypt($data['password']);
        $data['date_of_birth'] = isset($data['date_of_birth']) ? Carbon::parse($data['date_of_birth']) : null;
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        return User::create($data);

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
            return $user->delete();
        return false;
    }//end of delete

    public function update($id, $data)
    {
        $data['password'] = bcrypt($data['password']);
        $data['date_of_birth'] = Carbon::parse($data['date_of_birth']);
        isset($data['is_active']) ? $data['is_active'] = 1 : $data['is_active'] = 0;


        $user = User::find($id);
        if ($user)
            $user->update($data);
        return false;
    }//end of update

    public function updateOrCreateNabadatWallet(User $user, $package): bool
    {
        if (!$user)
            return false;
        $old_pulses = optional($user->nabadatWallet)->total_pulses ?? 0;
        $total_pulses = $old_pulses + $package->num_nabadat;
        $user_package_data = [
            'package_id' => $package->id,
            'num_nabadat' => $package->num_nabadat,
            'price' => $package->price
        ];
        logger('inside user service');
        $user->package()->create($user_package_data);
        $user->nabadatWallet()->updateOrCreate(['user_id' => $user->id], ['total_pulses' => $total_pulses]);
        return true;
    }


    public function updateOrCreateUserCenterNabadatWallet(User $user, $package, $payment_type = Order::PAYMENTCASH, $payment_status = Order::UNPAID): bool
    {
        if (!$user || !$package)
            return false;
        $centerNabadatWallet = $user->centerNabadatWallet()->where('center_id', $package->center_id)->first();
        $old_pulses = optional($centerNabadatWallet)->total_pulses ?? 0;
        $total_pulses = $old_pulses + $package->num_nabadat;
        $user_package_data = [
            'package_id' => $package->id,
            'num_nabadat' => $package->num_nabadat,
            'price' => $package->price
        ];
        $user->package()->create($user_package_data);
        $user->centerNabadatWallet()->updateOrCreate(['user_id' => $user->id], ['total_pulses' => $total_pulses, 'payment_type' => $payment_type, 'payment_status' => $payment_status]);
        return true;
    }

    function updateUsedPulses($num_decrement_pulses, User $user,$center_id =null)
    {
        if ($center_id == null) //pulses will minus from nambadat wallet if not pulses will minus from spacefic center
        {
            $total_pulses = optional($user->nabadatWallet)->total_pulses ?? 0;
            $used_pulses = optional($user->nabadatWallet)->used_pulses ?? 0 ;
            $user_balance_pulses = $total_pulses - $used_pulses ;
            if ($num_decrement_pulses > $user_balance_pulses){
                $total_used_pulses = $used_pulses+$user_balance_pulses ;
                $remain_pulses = abs($user_balance_pulses - $num_decrement_pulses) ;
            }


        }
        if ($center_id != null)
        {

        }
    }


    private function updateUserCenterNabadatWallet($num_decrement_pulses , $user , $center_id)
    {
        $centerNabadatWallet = $user->centerNabadatWallet()->where('center_id', $center_id)->first();
        $total_pulses = optional($centerNabadatWallet)->total_pulses ?? 0;
        $used_pulses = optional($centerNabadatWallet)->used_pulses ?? 0 ;
        $user_balance_pulses = $total_pulses - $used_pulses ;
        if ($num_decrement_pulses  > $user_balance_pulses){
            $remain_pulses = $num_decrement_pulses - $user_balance_pulses;
            $total_used_pulses = $used_pulses + $user_balance_pulses ;
            $centerNabadatWallet->update(['used_pulses'=>$total_used_pulses]);
            return $remain_pulses ;
        }
        $total_used_pulses = $used_pulses+$num_decrement_pulses ;
        return $centerNabadatWallet->update(['used_pulses'=>$total_used_pulses]);

    }
}
