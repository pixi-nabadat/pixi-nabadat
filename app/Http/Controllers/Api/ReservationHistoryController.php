<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Exceptions\StatusNotEquelException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationHistoryStoreRequest;
use App\Http\Resources\ReservationsResource;
use App\Services\ReservationHistoryService;
use App\Services\ReservationService;

class ReservationHistoryController extends Controller
{
    public function __construct(public ReservationHistoryService $reservationHistoryService, public ReservationService $reservationService)
    {

    }

    public function store(ReservationHistoryStoreRequest $request, $id)
    {
        try {
            $reservation = $this->reservationService->findById($id);
            $reservationHistoryData = $request->validated();
            $this->reservationHistoryService->store($reservation, $reservationHistoryData);
            $reservation = new ReservationsResource($reservation);
            return apiResponse($reservation, trans('lang.reservation_status_updated_successfully'));
        } catch (NotFoundException|StatusNotEquelException $e) {
            return apiResponse(null, $e->getMessage(), $e->getCode());
        }
    }
}
