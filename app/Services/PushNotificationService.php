<?php

namespace App\Services;


use App\Models\Doctor;
use App\Models\User;
use App\QueryFilters\DoctorsFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class PushNotificationService extends BaseService
{

    public function sendFcm(array $data = []): array
    {
        $filters = ['type'=>User::CUSTOMERTYPE];
        if (!Arr::has($data['users'],'all'))
            $filters['users'] = $data['users'] ;
        if (!Arr::has($data['locations'],'all'))
            $filters['locations'] = $data['locations'];
        if (!Arr::has($data['centers'],'all'))
            $filters['where_has_reservation'] = $data['centers'];
        $users = app()->make(UserService::class)->getAll($filters);
        $device_tokens =  $users->pluck('device_token');
        return array_filter($device_tokens);
    } //end of store

    public function update(int $id, array $doctorData = [])
    {

    }

    public function find(int $doctorId, array $withRelations = [])
    {

    }

    public function delete($id)
    {

    } //end of delete
}
