<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CouponsResource;
use App\Services\CouponService;

class CouponController extends Controller
{
    public function __construct(protected CouponService $couponService)
    {
    }


    public function listing(): \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $filters = ['is_active' => 1];
            $filters['in_period'] = true;
            $coupons = $this->couponService->listing(filters: $filters);
            return CouponsResource::collection($coupons);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }

}
