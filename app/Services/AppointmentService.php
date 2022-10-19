<?php

namespace App\Services;


use App\Models\User;
use App\QueryFilters\UsersFilter;
use Illuminate\Database\Eloquent\Builder;

class AppointmentService extends BaseService
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

}
