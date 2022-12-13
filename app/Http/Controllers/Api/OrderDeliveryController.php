<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderDeliveryStoreRequest;
use App\Http\Resources\OrderDeliveryResource;
use App\Services\OrderDeliveryService;
use Exception;

class OrderDeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(private OrderDeliveryService $orderDeliveryService)
    {

    }

    /**
     * @param OrderDeliveryStoreRequest $request
     * @return OrderDeliveryResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function payCash(OrderDeliveryStoreRequest $request)
    {
        try{
            $order = $this->orderDeliveryService->payCash($request->validated());
            if($order)
                return new OrderDeliveryResource($order);
            else
                return apiResponse(message: "Something went wrong", code: 422);
        }catch(Exception $e){
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }
}
