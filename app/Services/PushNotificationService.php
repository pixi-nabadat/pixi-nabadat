<?php

namespace App\Services;


use App\Models\Doctor;
use App\QueryFilters\DoctorsFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PushNotificationService extends BaseService
{

    public function sendFcm(array $data = [])
    {

    } //end of store

    public function update(int $id, array $doctorData = [])
    {

    }

    public function find(int $doctorId, array $withRelations = []): Doctor|Model|bool
    {

    }

    public function delete($id)
    {

    } //end of delete
}
