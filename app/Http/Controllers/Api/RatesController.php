<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatesStoreRequest;
use App\Services\RatesService;
use Exception;

class RatesController extends Controller
{
    public function __construct(private RatesService $ratesService)
    {
        
    }

    public function store(RatesStoreRequest $request)//: \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try{
            $data = $request->validated();//contain user_id, item_type, item_id, rate, status, comment
            $status = $this->ratesService->store(data: $data);
            if($status)
                return apiResponse(message: "item Estimated successfully", code: 200);
                else
                return apiResponse(message: "Something went wrong", code: 422);
                
            }catch(Exception $e){
                return apiResponse(message: "Something went wrong", code: 422);
            }
        }
        
        public function destroy($id)
        {
            try{
                $status = $this->ratesService->destroy($id);
                if($status)
                    return apiResponse(message: "Rate Deleted successfully", code: 200);
                else
                    return apiResponse(message: "Something went wrong", code: 422);
                
            }catch(Exception $e){
                return apiResponse(message: "Something went wrong", code: 422);
            }
    }
}
