<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NabadatHistoryStoreRequest;
use App\Http\Resources\nabadatHistoryResource;
use App\Http\Resources\ReservationsResource;
use App\Services\NabadatHistoryService;
use Exception;
use Illuminate\Http\Request;

class NabadatHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(private NabadatHistoryService $nabadatHistoryService)
    {

    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Requests\ReservationStoreRequest  $ReservationStoreRequest
     * @return \Illuminate\Http\Response
     */
    public function store(NabadatHistoryStoreRequest $nabadatHistoryStoreRequest)
    {
        try{
            $request = $nabadatHistoryStoreRequest->validated();
            $data = $this->nabadatHistoryService->store($request);
            $data = new ReservationsResource($data);
            if($data)
                return apiResponse(data: $data, message: 'done', code: 200);
            else
                return apiResponse(data: null, message: 'Something went rong.', code: 422);
        }catch(Exception $e){
            return apiResponse(data: null, message: $e->getMessage(), code: 300);
        }
    }
}
