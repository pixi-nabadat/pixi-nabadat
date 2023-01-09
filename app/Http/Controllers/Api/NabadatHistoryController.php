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

    public function store(NabadatHistoryStoreRequest $request)
    {
        try{
            $request = $request->validated();
            $data = $this->nabadatHistoryService->store($request);
            if($data)
                return apiResponse(data: new ReservationsResource($data),message: trans('lang.operation_success'));
            else
                return apiResponse( message: trans('lang.something_went_wrong.'), code: 422);
        }catch(Exception $e){
            return apiResponse(data: null, message: $e->getMessage(), code: 300);
        }
    }
}
