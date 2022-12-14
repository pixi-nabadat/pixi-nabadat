<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductEstimationStoreRequest;
use App\Services\ProductEstimationService;
use Exception;
use Illuminate\Http\Request;

class ProductEstimationController extends Controller
{

    public function __construct(private ProductEstimationService $productEstimationService )
    {

    }

    /**
     * @param int $id
     * @param ProductEstimationStoreRequest $request
     * @return \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function store(ProductEstimationStoreRequest $request)//: \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try{
            $data = $request->validated();
            if(isset($request['estimation'])){
                $status = $this->productEstimationService->store(data: $data);
                if($status)
                    return apiResponse(message: "producted Estimated successfully", code: 200);
                else
                    return apiResponse(message: "Something went wrong", code: 422);
    
            }else{
                return apiResponse(message: "Something went wrong", code: 422);
            }

        }catch(Exception $e){
            return apiResponse(message: "Something went wrong", code: 422);
        }
        
    }
}
