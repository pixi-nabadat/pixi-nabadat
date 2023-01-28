<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationHistoryStoreRequest;
use App\Models\Reservation;
use App\Services\ReservationHistoryService;
use Exception;
use Illuminate\Http\Request;

class ReservationHistoryController extends Controller
{
    public function __construct(public ReservationHistoryService $reservationHistoryService)
    {

    }

    public function store(ReservationHistoryStoreRequest $request, $id)
    {
        try{
            $reservation = Reservation::find($id);
            if($reservation){
                $reservationHistoryData = $request->validated();
                $response = $this->reservationHistoryService->store($reservation, $reservationHistoryData);
                $toast = ['type' => 'success', 'title' => 'Success', 'message' => trans('lang.operation_success')];
                return redirect()->route('reservations.index')->with('toast', $toast);
            }
        } catch (Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    }
}
