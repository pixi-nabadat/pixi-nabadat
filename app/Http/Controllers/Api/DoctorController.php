<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DoctorService;
use App\Http\Requests\StoreDoctorRequest as StoreDoctorReqest;
use App\Http\Requests\StoreDoctorRequest as updateDoctorReqest;
use App\Exceptions\BadRequestHttpException;

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

    public function getAllDoctors(Request $request)
    {
        try {
            $filters = ['is_active' =>$request->is_active ?? 1, 'name' => $request->name, 'center_id' => $request->center_id];
            $list = $this->doctorService->getAll($filters);
            return apiResponse($list,__('lang.success'));
        } catch (\Exception $e) {
            return apiResponse($e->getMessage(),$e->getCode());
        }
    }

    public function storeDoctor(StoreDoctorReqest $request)
    {
        try {
            $this->doctorService->storeDoctor($request->all());
            return apiResponse(message:__('lang.doctor_saved_successfully'),code: 200);
        } catch(BadRequestHttpException $ex) {
            throw new BadRequestHttpException($ex->getMessage(), 400);
        }
    }

    public function editDoctor($id, updateDoctorReqest $request)
    {
        try {
            $this->doctorService->updateDoctor($id, $request->all());
            return apiResponse(message:__('lang.doctor_updated_successfully'),code: 200);
        } catch(BadRequestHttpException $ex) {
            throw new BadRequestHttpException($ex->getMessage(), 400);
        }
    }

    public function findDoctor($doctorId)
    {
        try {
            $data = $this->doctorService->getDoctorById($doctorId);
            return apiResponse($data,__('lang.success'));
        } catch(BadRequestHttpException $ex) {
            throw new BadRequestHttpException($ex->getMessage(), 400);
        }
    }

    public function deleteDoctor($doctorId)
    {
        try {
            $data = $this->doctorService->deleteDoctor($doctorId);
            return apiResponse($data,__('lang.success'));
        } catch(BadRequestHttpException $ex) {
            throw new BadRequestHttpException($ex->getMessage(), 400);
        }
    }
}
