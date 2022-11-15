<?php

namespace App\Services;


use App\Models\Doctor;
use App\QueryFilters\DoctorsFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\BadRequestHttpException;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\DoctorsResource;

class DoctorService extends BaseService
{
    public function queryGet(array $filters = [] , array $withRelation = []) :builder
    {
        $doctors = Doctor::query()->with($withRelation);
        return $doctors->filter(new DoctorsFilter($filters));
    }

    public function listing(array $filters = [] , array $withRelation =[] ): \Illuminate\Contracts\Pagination\CursorPaginator
    {
        $perPage = config('app.perPage');
        return $this->queryGet(filters: $filters,withRelation: $withRelation)->cursorPaginate($perPage);
    }

    public function store(array $data = [])
    {
        $data['is_active'] = isset($data['is_active'])  ?  1 :  0;

        $doctor = Doctor::create($data);
        if (!$doctor)
            return false ;

        if (isset($data['image']))
        {
            $fileData = FileService::saveImage(file: $data['image'],path: 'uploads\doctors');
            $doctor->storeAttachment($fileData);
        }
        return $doctor;
    } //end of store

    public function update(int $id, array $doctorData=[])
    {
        $doctor = $this->find($id);
        if (!$doctor)
            return false;
        return $doctor->update($doctorData);
    }

    public function find(int $doctorId , array $withRelations = []): Doctor|Model|bool
    {
        $doctor =  Doctor::with($withRelations)->find($doctorId);
        if (!$doctor)
            return false;
        return $doctor;
    }

    public function delete($id)
    {
        $doctor = $this->find($id);
        if ($doctor) {
            $doctor->deleteAttachments();
            return $doctor->delete();
        }
        return false;
    } //end of delete
}
