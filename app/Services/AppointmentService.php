<?php

namespace App\Services;


use App\Exceptions\NotFoundException;
use App\Models\Appointment;
use App\Models\User;
use App\QueryFilters\AppointmentsFilter;
use App\QueryFilters\UsersFilter;
use Illuminate\Database\Eloquent\Builder;

class AppointmentService extends BaseService
{

    public function getAll(array $where_condition = [],array $withRelations = [])
    {
        $appointments = $this->queryGet($where_condition,$withRelations);
        return $appointments->get();
    }

    public function queryGet(array $where_condition = [],array $withRelations = []): Builder
    {
        $appointments = Appointment::query()->with($withRelations);
        return $appointments->filter(new AppointmentsFilter($where_condition));
    }

    public function find(int $id,array $withRelations = []): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|Builder|bool|array
    {
        $appointment = Appointment::with($withRelations)->find($withRelations);
        if ($appointment)
            return $appointment;
        return false;

    }

    public function create(array $data = [])
    {
        return Appointment::create($data);
    }

    public function update(int $id , array $data = [])
    {
        return Appointment::where('id',$id)->update($data);
    }

    public function delete(int $id)
    {
        $appointment = Appointment::find($id);
        if (!$appointment)
            throw new NotFoundException(trans('lang.appointment_not_found'));
        return $appointment->delete();
    }
}
