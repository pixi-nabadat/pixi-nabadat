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
            $reservation = Reservation::find($id);
            if($reservation){
                $user = User::find($request->user_id);
                if($user){
                    $status = $request->status;
                    $response = $this->reservationHistoryService->store($user, $reservation, $status);
                    if($response){
                        $reservation = new ReservationsResource($reservation);
                        return apiResponse($reservation, 'Done', 200);
                    }
                }else{
                    return apiResponse(null,'User Not Found', 404);
                }
            }else{
                return apiResponse(null,'Reservation Not Found', 404);
            }
        }catch(StatusNotEquelException $e){
            return apiResponse(null,$e->getMessage(), $e->getCode());
        }
    } 
}