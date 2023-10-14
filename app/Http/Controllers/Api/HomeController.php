<?php

namespace App\Http\Controllers\Api;

use App\Enum\PackageStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\CentersResource;
use App\Http\Resources\CouponsResource;
use App\Http\Resources\HomeSearchResource;
use App\Http\Resources\LocationsResource;
use App\Http\Resources\PackagesResource;
use App\Http\Resources\product\ProductsResource;
use App\Http\Resources\SlidersResource;
use App\Models\Center;
use App\Models\Device;
use App\Models\Product;
use App\Services\CenterPackageService;
use App\Services\CenterService;
use App\Services\CouponService;
use App\Services\LocationService;
use App\Services\ProductService;
use App\Services\SliderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct(protected ProductService  $productService,
                                protected CenterService   $centerService,
                                protected LocationService $locationService,
                                protected SliderService   $sliderService,
                                protected CouponService   $couponService,
                                protected CenterPackageService $packageService)
    {
    }


    public function index(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $location_id = request()->input('location_id', null);
        $centers_filter = ['is_active' => 1, 'featured' => 1];
        if (isset($location_id))
            $centers_filter['location_id'] =  $location_id;

//        $data = Cache::remember('home-api', 60 * 60 * 24, function () use ($centers_filter) {
            $data ['featured_products'] = ProductsResource::collection($this->productService->getAll(where_condition: ['is_active' => 1, 'featured' => 1], withRelation: ['attachments','defaultLogo']));
            $data['center_packages'] = PackagesResource::collection($this->packageService->listing(where_condition: ['is_active' => 1, 'in_duration' => true, 'status' => PackageStatusEnum::APPROVED], withRelation: ['attachments','center.user:id,center_id,name', 'center.defaultLogo']));
            $data['locations'] = LocationsResource::collection($this->locationService->getAll(filters: ['depth' => 2]));
            $data['coupons'] = CouponsResource::collection($this->couponService->listing(filters: ['in_period' => true, 'is_active' => true]));
            $data['featured_centers'] = CentersResource::collection($this->centerService->listing(filters: $centers_filter, withRelation: ['defaultLogo']));
            $data['sliders'] = SlidersResource::collection($this->sliderService->listing(where_condition: ['is_active' => 1, 'in_duration'=> true], withRelations: ['attachments']));
//            return $data;
//        });
        return apiResponse(data: $data);
    }

    public function search(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $lang = app()->getLocale();
        $keyword = $request->keyword;
        $product = Product::query()->where('name', 'Like', "%$keyword%")->select(['id', 'name'])->limit(10)->get();
        $device = Device::query()->where('name', 'Like', "%$keyword%")->select(['id', 'name'])->limit(10)->get();
        $center = Center::query()->join('users', function ($query) use ($keyword) {
            $query->on('centers.id', '=', 'users.center_id');
            $query->where('users.name', 'LIKE', "%$keyword%");
        })->select(['centers.id as id', DB::raw("JSON_UNQUOTE(users.name->'$.$lang') as name")])->limit(10)->get();
        $result = $product->union($device);
        $finalResult = $result->union($center);
        $search_results = HomeSearchResource::collection($finalResult);
        return apiResponse(data: $search_results);
    }

}
