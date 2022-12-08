<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Resources\WeekDaysResource;
use App\Models\Appointment;
use App\Services\AppointmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class AppointmentController extends Controller
{
    public function __construct(public AppointmentService $appointmentService)
    {
    }


    public function index(): array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
    {
        return WeekDaysResource::collection(collect(Appointment::WEEKDAYS));
    }

    public function store(StoreAppointmentRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            foreach ($request->days as $day)
            {
                $inserted_data = [
                    'day_of_week'   =>$day,
                    'day_text'      =>Arr::except((Appointment::WEEKDAYS)[$day],'day_of_week'),
                    'is_active'     =>true,
                    'center_id'     =>$request->center_id
                ];
                $this->appointmentService->create($inserted_data);
             }
            return apiResponse(message: trans('lang.created_successfully'));
        }catch (\Exception $exception)
        {
            $message = trans('there is an error') ;
            if ($exception->getCode() == 23000) // database exception
                $message = trans('lang.data_already_exists');
            return apiResponse(message: $message);
        }


    } //end of store

    public function update(UpdateAppointmentRequest $request , $id): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $is_active = $request->is_active ?? 0;
            $updated_data = [
                'is_active'     =>$is_active
            ];
            $this->appointmentService->update($id , $updated_data);
            return apiResponse(message: trans('lang.updated_successfully'));
        }catch (\Exception $exception)
        {
            return apiResponse(message: trans('there is an error'));
        }
    } //end of update

    public function destroy($id): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $this->appointmentService->delete($id);
            return apiResponse(message: trans('lang.deleted_successfully'));
        }catch (\Exception $exception)
        {
            return apiResponse(message: trans('there is an error'));
        }
    }
}
