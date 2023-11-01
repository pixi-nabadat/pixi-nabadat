<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Exceptions\StatusNotEquelException;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationAttendRequest;
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
            $reservationHistoryData['added_by'] = $request->added_by;
            $this->reservationHistoryService->store($reservation, $reservationHistoryData);
            $reservation = new ReservationsResource($reservation);
            return apiResponse($reservation, trans('lang.reservation_status_updated_successfully'));
        } catch (NotFoundException|StatusNotEquelException $e) {
            return apiResponse(null, $e->getMessage(), $e->getCode());
        }
    }

    public function reservationAttend(ReservationAttendRequest $request)
    {
        try {
            $reservation = $this->reservationService->findByQrCode($request->qr_code);
            $reservationHistoryData = $request->validated();
            $reservationHistoryData['added_by'] = $request->added_by;
            $this->reservationHistoryService->store($reservation,$reservationHistoryData);
            $reservation = new ReservationsResource($reservation);
            return apiResponse($reservation, trans('lang.reservation_status_updated_successfully'));
        } catch (NotFoundException|StatusNotEquelException $e) {
            return apiResponse(null, $e->getMessage(), $e->getCode());
        }
    }
}
