<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorRequest as StoreDoctorRequest;
use App\Http\Requests\StoreDoctorRequest as UpdateDoctorRequest;
use App\Http\Resources\DoctorsResource;
use App\Services\DoctorService;
use Illuminate\Http\Request;

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

    public function listing(Request $request): \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $filters = $request->all();
            $filters ['center_id'] = auth('sanctum')->user()->center_id;
            $withRelation = ['defaultLogo'];
            $doctors = $this->doctorService->listing($filters,$withRelation);
            return DoctorsResource::collection($doctors);
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: $e->getCode());
        }
    }

    public function store(StoreDoctorRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $this->doctorService->store($request->validated());
            return apiResponse(message: __('lang.doctor_saved_successfully'));
        } catch (\Exception $ex) {
            return apiResponse(message: $ex->getMessage(), code: 422);
        }
    }

    public function find($id)
    {
        try {
            $withRelation = ['defaultLogo'];
            $doctor = $this->doctorService->find(doctorId: $id, withRelations: $withRelation);
            return new DoctorsResource($doctor);
        } catch (\Exception $ex) {
            return apiResponse(message: $ex->getMessage(), code: 422);
        }
    }


    public function update($id, UpdateDoctorRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $doctor = $this->doctorService->update($id, $request->validated());
            $response = new DoctorsResource(resource: $doctor);
            return apiResponse(data:$response,message: __('lang.doctor_updated_successfully'));
        } catch (\Exception $ex) {
            return apiResponse(message: $ex->getMessage(), code: 422);
        }
    }

    public function destroy($id)
    {
        try {
            $this->doctorService->delete($id);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy
}
