<?php

namespace App\Services;


use App\Models\Doctor;
use App\QueryFilters\DoctorsFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\BadRequestHttpException;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\GetListDoctortResource;

class DoctorService extends BaseService
{
    public function queryGet(array $where_condition = [])
    {
        $doctors = Doctor::query();
        return $doctors->filter(new DoctorsFilter($where_condition));
    }

    public function getAll(array $where_condition = [])
    {
        $doctors = $this->queryGet($where_condition);
        $doctors = $doctors->cursorPaginate(10);
        return GetListDoctortResource::collection($doctors);
    }

    public function storeDoctor(array $doctorData=[]): mixed
    {
        $center_id =  $doctorData['center_id'] ?? Auth::user()->center_id ?? 1 ;
        if (! $center_id)
            return throw new BadRequestHttpException(__('lang.invalid_inputs'), 400);
        return Doctor::create($doctorData);
    }

    public function updateDoctor(int $id, array $doctorData=[])
    {
        $doctor_id = $this->getDoctorById($id);
        if (! $doctor_id)
            return throw new BadRequestHttpException(__('lang.invalid_inputs'), 400);
        return Doctor::where('id', $id)->update($doctorData);
    }

    public function getDoctorById($doctorId): Doctor|Model
    {
        $doctor =  Doctor::find($doctorId);
        if (! $doctor)
            return throw new BadRequestHttpException(__('lang.invalid_inputs'), 400);
        return $doctor;
    }

    public function deleteDoctor($doctorId)
    {
        $doctor = $this->getDoctorById($doctorId);
        if ($doctor)
            return $doctor->delete();
        return false;
    }
}
