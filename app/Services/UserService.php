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
        $data['date_of_birth'] = Carbon::parse($data['date_of_birth']);
        isset($data['is_active'])  ?   $data['is_active']=1 : $data['is_active']= 0;
        return User::create($data);

    } //end of create

    public function find($id)
    {
        $user = User::find($id);
        if ($user)
            return $user;
        return false;
    }

    public function changeStatus($id)
    {
        $user = User::find($id);
        $user->is_active = !$user->is_active;
        $user->save();
    }//end of changeStatus

    public function delete($id)
    {
        $user=User::find($id);
        if ($user)
            return $user->delete();
        return false;
    }//end of delete

    public function update($id , $data)
    {
        $data['password'] = bcrypt($data['password']);
        $data['date_of_birth'] = Carbon::parse($data['date_of_birth']);
        isset($data['is_active'])  ?   $data['is_active']=1 : $data['is_active']= 0;


        $user=User::find($id);
        if ($user)
            $user->update($data);
        return false;
    }//end of update

}
