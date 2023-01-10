<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Http\Resources\WeekDaysResource;
use App\Models\Appointment;
use App\Services\AppointmentService;
use Illuminate\Support\Arr;

class AppointmentController extends Controller
{
    public function __construct(public AppointmentService $appointmentService)
    {
    }

    public function index(): \Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response|array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        if (!isset(auth()->user()->center_id))
            return apiResponse(message: trans('lang.center_not_found'));
        $filters = ['center_id'=>auth()->user()->center_id];
        $center_appointments= $this->appointmentService->getAll($filters);
        return  apiResponse(data: $center_appointments);
    }

    public function store(StoreAppointmentRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {

            $data = $request->validated();
            $inserted_data = [
                'day_of_week' => $data['day'],
                'day_text' => Arr::except((Appointment::WEEKDAYS)[$data['day']], 'day_of_week'),
                'is_active' => true,
                'center_id' => $data['center_id'],
                'from' => $data['from'],
                'to' => $data['to'],
            ];
            $this->appointmentService->create($inserted_data);
            return apiResponse(message: trans('lang.created_successfully'));
        } catch (\Exception $exception) {
            $message = trans('there is an error');
            if ($exception->getCode() == 23000) // database exception
                $message = trans('lang.data_already_exists');
            return apiResponse(message: $message);
        }
    } //end of store

    public function update(UpdateAppointmentRequest $request, $id): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $is_active = $request->is_active ?? 0;
            $updated_data = [
                'is_active' => $is_active,
                'to' => $request->to,
                'from' => $request->from,
            ];
            $this->appointmentService->update($id, $updated_data);
            return apiResponse(message: trans('lang.updated_successfully'));
        } catch (\Exception $exception) {
            return apiResponse(message: trans('there is an error'));
        }
    } //end of update

    public function destroy(int $id): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $this->appointmentService->delete($id);
            return apiResponse(message: trans('lang.deleted_successfully'));
        }catch (NotFoundException $exception){
            return apiResponse(message: $exception->getMessage());
        }
        catch (\Exception $exception) {
            return apiResponse(message: trans('there is an error'));
        }
    }

    public function getWeekDays(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return WeekDaysResource::collection(collect(Appointment::WEEKDAYS));
    }
}
