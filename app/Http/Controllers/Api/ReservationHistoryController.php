<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Exceptions\StatusNotEquelException;
use App\Http\Requests\ReservationHistoryStoreRequest;
use App\Http\Resources\ReservationsResource;
use App\Models\Reservation;
use App\Models\User;
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
            $reservation = Reservation::with(['center','user','history'])->find($id);
            if($reservation){
                $reservationHistoryData = $request->validated();
                $response = $this->reservationHistoryService->store($reservation, $reservationHistoryData);
                if($response){
                    $reservation = new ReservationsResource($reservation);
                    return apiResponse(data: $reservation, message: 'Done');
                }
            }else{
                return apiResponse(null,'Reservation Not Found', 404);
            }
        }catch(Exception|StatusNotEquelException $e){
            return apiResponse(null,$e->getMessage(), $e->getCode());
        }
    }
}
