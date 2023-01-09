<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReferalPointsRequest;
use App\Services\ReferalService;
use Exception;
use Illuminate\Http\Request;

class ReferalController extends Controller
{
    public function __construct(private ReferalService $referalService)
    {
        
    }

    public function setReferalPoints(ReferalPointsRequest $request)
    {
        try{
            $status = $this->referalService->setReferalPoints($request->validated());
            if($status)
                return apiResponse(message: trans('lang.succes_operation'));
            else
                return apiResponse(message: trans('lang.failed_operation'), code: 422);

        }catch(Exception $e){
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }
}
