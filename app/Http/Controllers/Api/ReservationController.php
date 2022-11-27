<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Exceptions\NotFoundHttpException;
use App\Exceptions\StatusNotEquelException;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\ReservationStoreRequest;
use App\Http\Requests\ReservationUpdateRequest;
use App\Http\Resources\CentersResource;
use App\Http\Resources\ReservationsResource;
use Carbon\Carbon;
use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Validation\Rules\Unique;
use App\Models\User;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(private ReservationService $reservationService)
    {

    }

    public function listing(Request $request): \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
//            
            $filters = $request->all();

            $withRelations = ['history','nabadatHistory','user', 'center'];
            $reservations = $this->reservationService->listing(filters: $filters,withRelation: $withRelations);
            return ReservationsResource::collection($reservations);
        } catch (\Exception $e) {
            return apiResponse($e->getMessage(), 'Unauthorized',$e->getCode());
        }
    }

    /////////////////////////

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\ReservationStoreRequest  $ReservationStoreRequest
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationStoreRequest $reservationStoreRequest)
    {
        try{
            $reservationStoreRequest = $reservationStoreRequest->validated();
            $reservationData = [
                'customer_id' => $reservationStoreRequest['customer_id'],
                'center_id'   => $reservationStoreRequest['center_id'],
                'check_date'  => $reservationStoreRequest['check_date'],
            ];
            $reservation = $this->reservationService->store($reservationData);
            $reservation = new ReservationsResource($reservation);
            if($reservation)
                return apiResponse($reservation, 'done', 200);
        }catch(Exception $e){
            return apiResponse($e->getMessage(), 'Unauthorized',$e->getCode());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        try{
            $reservation = Reservation::find($id);
            if($reservation){
                $reservation = $this->reservationService->find($reservation);
                $reservation = ReservationsResource::collection($reservation);
                return apiResponse($reservation, 'Done', 200);
            }
        
        }catch(Exception $e){
            return apiResponse(null, $e->getMessage(), $e->getCode());
        }
    }
    
}
