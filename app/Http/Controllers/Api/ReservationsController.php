<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationStoreRequest;
use App\Http\Requests\ReservationUpdateRequest;
use App\Http\Resources\ReservationsResource;
use App\Services\ReservationService;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    public function __construct(public ReservationService $reservationService)
    {
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function centerReservations(Request $request): \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try{
            dd('test');
            $filters = $request->all();
            if (auth('sanctum')->user()->center_id == null)
                throw new NotFoundException('route not found');
            $withRelations = ['latestStatus', 'user'];
            $reservations = $this->reservationService->listing(filters: $filters, withRelation: $withRelations);
            return ReservationsResource::collection($reservations);
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

    public function patientReservations(Request $request): \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try{
            $filters = $request->all();
            $filters['user_id'] = auth('sanctum')->id();
            $withRelations = ['latestStatus', 'nabadatHistory', 'center'];
            $reservations = $this->reservationService->listing(filters: $filters, withRelation: $withRelations);
            return ReservationsResource::collection($reservations);
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

    public function store(ReservationStoreRequest $reservationStoreRequest): \Illuminate\Http\Response|ReservationsResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $reservation = $this->reservationService->store($reservationStoreRequest->validated());
            return apiResponse(data: new ReservationsResource($reservation));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

    public function find(int $id)
    {
        try {
            $withRelations = ['latestStatus', 'nabadatHistory', 'user', 'center'];
            $reservation = $this->reservationService->findById($id, $withRelations);
            if ($reservation)
                return apiResponse(new ReservationsResource($reservation), trans('lang.operation_success'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

    public function update(int $id, ReservationUpdateRequest $request )
    {
        try {
            $reservation = $this->reservationService->update(reservationId: $id,reservationData: $request->validated());
            if ($reservation)
                return apiResponse(trans('lang.reservation_updated_successfully'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

    public function findByQrCode(string $id)
    {
        try {
            $withRelations = ['latestStatus', 'nabadatHistory', 'user', 'center'];
            $reservation = $this->reservationService->findByQrCode($id, $withRelations);
            if ($reservation)
                return apiResponse(new ReservationsResource($reservation), trans('lang.operation_success'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

    public function delete(int $id): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $this->reservationService->destroy($id);
            return apiResponse(message: trans('lang.operation_success'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

    public function findForEdit(int $id)
    {
        try {
            $reservation = $this->reservationService->findById($id);
            if ($reservation)
                return apiResponse(new ReservationsResource($reservation), trans('lang.operation_success'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }
}
