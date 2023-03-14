<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CentersResource;
use App\Http\Resources\CouponsResource;
use App\Http\Resources\HomeSearchResource;
use App\Http\Resources\LocationsResource;
use App\Http\Resources\PackagesResource;
use App\Http\Resources\product\ProductsResource;
use App\Http\Resources\ReservationsResource;
use App\Http\Resources\SlidersResource;
use App\Models\Center;
use App\Models\Device;
use App\Models\Product;
use App\Models\Reservation;
use App\Services\CenterPackageService;
use App\Services\CenterService;
use App\Services\CouponService;
use App\Services\LocationService;
use App\Services\ProductService;
use App\Services\ReservationService;
use App\Services\SliderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CenterHomeController extends Controller
{
    public function __construct(protected ReservationService  $reservationService)
    {
    }


    public function index(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $centerId = auth('sanctum')->user()->center_id;
        $data = Cache::remember('center-home-api', 60 * 60 * 24, function () use ($centerId) {
            $data ['upcoming_reservations'] = ReservationsResource::collection($this->reservationService->listing(filters: ['center_id'=> $centerId, 'status' => Reservation::PENDING], withRelation: ['user', 'center', 'nabadatHistory', 'latestStatus']));
            return $data;
        });
        return apiResponse(data: $data);
    }


}
