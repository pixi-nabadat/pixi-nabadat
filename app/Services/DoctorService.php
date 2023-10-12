<?php

namespace App\Services;

use App\Enum\ImageTypeEnum;
use App\Exceptions\NotFoundException;
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
        $data['is_active'] = isset($data['is_active'])  ? 1 :  0;
        $doctor = Doctor::create($data);
        if (!$doctor)
            return false ;

        if (isset($data['logo']))
        {
            $fileData = FileService::saveImage(file: $data['logo'],path: 'uploads/doctors', field_name: 'logo');
            $fileData['type'] = ImageTypeEnum::LOGO;
            $doctor->storeAttachment($fileData);
        }
        return $doctor;
    } //end of store

    public function update(int $id, array $data=[])
    {
        $doctor = $this->find($id);
        if (!$doctor)
            return false;
        if (isset($data['logo']))
        {
            if ($doctor->attachments()->count())
                $doctor->deleteAttachments();
            $fileData = FileService::saveImage(file: $data['logo'],path: 'uploads/doctors', field_name: 'logo');
            $fileData['type'] = ImageTypeEnum::LOGO;
            $doctor->storeAttachment($fileData);
        }
        $data['is_active'] = isset($data['is_active'])  ? 1 :  0;
        $doctor->update($data);
        return $doctor;
    }

    /**
     * @throws NotFoundException
     */
    public function find(int $doctorId , array $withRelations = []): Doctor|Model|bool
    {
        $doctor =  Doctor::with($withRelations)->find($doctorId);
        if (!$doctor)
           throw new NotFoundException(trans('lang.doctor_no_found'));
        return $doctor;
    }

    /**
     * @throws NotFoundException
     */
    public function delete($id)
    {
        $doctor = $this->find($id);
        $doctor->deleteAttachments();
        return $doctor->delete();
    } //end of delete

    public function status($id)
    {
        $doctor = $this->find($id);
        $doctor->is_active = !$doctor->is_active;
        return $doctor->save();

    }//end of status

}
