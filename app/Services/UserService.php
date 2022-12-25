<?php

namespace App\Services;

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
        $old_pulses = $user->nabadatWallet->total_pulses ?? 0;
        $total_pulses = $old_pulses + $package->num_nabadat;
        $user_package_data = [
            'package_id' => $package->id,
            'num_nabadat' => $package->num_nabadat,
            'price' => $package->price
        ];
        logger('inside user service');
        $user->package()->create($user_package_data);
        $user->nabadatWallet()->updateOrCreate(['user_id'=>$user->id],['total_pulses' => $total_pulses]);
        return true;
    }
}
