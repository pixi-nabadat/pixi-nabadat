<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorRequest as StoreDoctorReqest;
use App\Http\Requests\StoreDoctorRequest as updateDoctorReqest;
use App\Http\Resources\DoctorsResource;
use App\Services\DoctorService;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(private DoctorService $doctorService)
    {
    }

    public function store(StoreDoctorReqest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $this->doctorService->store($request->validated());
            return apiResponse(message: __('lang.doctor_saved_successfully'));
        } catch (\Exception $ex) {
            return apiResponse(message: $ex->getMessage(), code: 422);
        }
    }

    public function update($id, updateDoctorReqest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $this->doctorService->update($id, $request->validated());
            return apiResponse(message: __('lang.doctor_updated_successfully'));
        } catch (\Exception $ex) {
            return apiResponse(message: $ex->getMessage(), code: 422);
        }
    }

    public function find($id)
    {
        try {
            $withRelation = ['center'];
            $doctor = $this->doctorService->find(doctorId: $id, withRelations: $withRelation);
            return new DoctorsResource($doctor);
        } catch (\Exception $ex) {
            return apiResponse(message: $ex->getMessage(), code: 422);
        }
    }


    public function destroy($id)
    {
        try {
            $result = $this->doctorService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy
}
