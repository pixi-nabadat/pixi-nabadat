<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponUsageStoreRequest;
use App\Http\Resources\CartsResource;
use App\Http\Resources\DeviceResource;
use App\Services\CouponService;
use App\Services\CouponUsageService;
use Exception;
use Illuminate\Http\Request;

class CouponUsageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(private CouponUsageService $couponUsageService)
    {

    }

    public function store(CouponUsageStoreRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $response = $this->couponUsageService->store($request->validated());
            if($response['status']){
                $cart = new CartsResource($response['data']);
                return apiResponse(data: $cart, message: "Done", code: 200);
            }
            else
                return apiResponse(data: null, message: $response['message'], code: 422);

        } catch (\Exception $ex) {
            return apiResponse(data: null, message: $ex->getMessage(), code: 422);
        }
    }
    
    public function simulation(CouponUsageStoreRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $response = $this->couponUsageService->simulation($request->validated());
            if($response['status'])
                return apiResponse(data: ['new_balance' => $response['data']], message: "Done", code: 200);
            else
                return apiResponse(data: null, message: $response['message'], code: 422);

        } catch (\Exception $ex) {
            return apiResponse(data: null, message: $ex->getMessage(), code: 422);
        }
    }
}
