<?php

namespace App\Http\Controllers\APi;

use App\Exceptions\NotFoundException;
use App\Exceptions\NotFoundHttpException;
use App\Exceptions\StatusNotEquelException;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\ReservationStoreRequest;
use App\Http\Requests\ReservationUpdateRequest;
use App\Http\Resources\CentersResource;
use Carbon\Carbon;
use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Validation\Rules\Unique;
use App\Models\User;

class ReservationController extends Controller
{
    private $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService =  $reservationService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $reservations = $this->reservationService->index();
            $reservations = ReservationResource::collection($reservations);
            return response()->json(['status'=>'true', 'message'=>'done', 'data'=>$reservations]);
        }catch(Exception $e){
            return response()->json(['status'=>'false', 'message'=>$e->getMessage(), 'data'=>$reservations]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            $centers = $this->reservationService->create();
            $centers = CentersResource::collection($centers);
            return response()->json(['status'=>'true', 'message'=>'done', 'data'=>$centers]);
        }catch(Exception $e){
            $centers = CentersResource::collection($centers);
            return response()->json(['status'=>'false', 'message'=>$e->getMessage(), 'data'=>$centers]);
        }
    }

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
                'qr_code'     => uniqid(),
            ];
            $reservation = $this->reservationService->store($reservationData);
            $reservation = new ReservationResource($reservation);
            return response()->json(['status'=>'true', 'message'=>'done', 'data'=>$reservation]);
        }catch(Exception $e){
            return response()->json(['status'=>'false', 'message'=>$e->getMessage(), 'data'=>[]]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $reservation = Reservation::findOrFail($id);

            $reservation = $this->reservationService->show($reservation);
            $reservation = new ReservationResource($reservation);
            return response()->json(['status'=>'true', 'message'=>'Done', 'data'=>$reservation]);
        
        }catch(Exception $e){
            return response()->json(['status'=>'false', 'message'=>$e->getMessage(), 'data'=>[]]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $reservation = Reservation::findOrFail($id);
            $reservation = $this->reservationService->edit($reservation);
            $reservation = new ReservationResource($reservation);
            return response()->json(['status'=>'true', 'message'=>'Done', 'data'=>$reservation]);
        }catch(Exception $e){
            return response()->json(['status'=>'false', 'message'=>$e->getMessage(), 'data'=>[]]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\ReservationUpdateRequest  $reservationUpdateRequest
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReservationUpdateRequest $reservationUpdateRequest, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $reservation = Reservation::findOrFail($id);
            $this->reservationService->destroy($reservation);
            $reservation = new ReservationResource($reservation);
            return response()->json(['status'=>'true', 'message'=>'Reservation Deleted', 'data'=>$reservation]);
        }catch(Exception $e){
            return response()->json(['status'=>'false', 'message'=>$e->getMessage(), 'data'=>[]]);
        }
    }
    
    public function confirm(Request $request, $id){
        try{
            $reservation = Reservation::findOrFail($id);
            $user = User::findOrFail($request->user_id);
            $this->reservationService->confirm($user, $reservation);
            $reservation = new ReservationResource($reservation);
            return response()->json(['status'=>'true', 'message'=>'Done', 'data'=>$reservation]);
        }catch(Exception $e){
            return response()->json(['status'=>'false', 'message'=>$e->getMessage(), 'data'=>[]]);
        }
    }
    public function attend(Request $request, $id){
        try{
            $reservation = Reservation::findOrFail($id);
            $user = User::findOrFail($request->user_id);
            $this->reservationService->attend($user, $reservation);
            $reservation = new ReservationResource($reservation);
            return response()->json(['status'=>'true', 'message'=>'Done', 'data'=>$reservation]);
        }catch(Exception $e){
            return response()->json(['status'=>'false', 'message'=>$e->getMessage(), 'data'=>[]]);
        }
    }
    public function cancel(Request $request, $id){
        try{
            $reservation = Reservation::findOrFail($id);
            $user = User::findOrFail($request->user_id);
            $this->reservationService->cancel($user, $reservation);
            $reservation = new ReservationResource($reservation);
            return response()->json(['status'=>'true', 'message'=>'Done', 'data'=>$reservation]);
        }catch(Exception $e){
            return response()->json(['status'=>'false', 'message'=>$e->getMessage(), 'data'=>[]]);
        }
    }
    public function complete(Request $request, $id){
        try{
            $reservation = Reservation::findOrFail($id);
            $user = User::findOrFail($request->user_id);
            $this->reservationService->complete($user, $reservation);
            $reservation = new ReservationResource($reservation);
            return response()->json(['status'=>'true', 'message'=>'Done', 'data'=>$reservation]);
        }catch(Exception $e){
            return response()->json(['status'=>'false', 'message'=>$e->getMessage(), 'data'=>[]]);
        }
    }
}
