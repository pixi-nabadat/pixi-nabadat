<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CentersResource;
use App\Http\Resources\HomeSearchResource;
use App\Http\Resources\LocationsResource;
use App\Http\Resources\product\ProductsResource;
use App\Models\Center;
use App\Models\Device;
use App\Models\Product;
use App\Services\CenterService;
use App\Services\LocationService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function __construct(protected ProductService $productService, protected CenterService $centerService, protected LocationService $locationService)
    {
    }


    public function index(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $user = auth('sanctum')->user();
        if (isset($user))
            $location_id = $user->location_id;
        else
            $location_id = request()->input('location_id');
        $data = Cache::remember('home-api', 60 * 60 * 24, function () use ($location_id) {
            $data ['featured_products'] = ProductsResource::collection($this->productService->getAll(where_condition: ['featured' => 1], withRelation: ['attachments']));
            $data ['featured_centers'] = CentersResource::collection($this->centerService->listing(filters: ['featured' => 1], withRelation: ['location', 'attachments']));
            $data ['sliders'] = [];
            $data['locations'] = LocationsResource::collection($this->locationService->getAll(filters: ['depth' => 2]));
            return $data;
        });

        return apiResponse(data: $data);
    }

    public function search(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $keyword = $request->keyword;
        $product = Product::query()->where('name', 'Like', "%$keyword%")->select(['id','name'])->limit(10)->get();
        $device = Device::query()->where('name', 'Like', "%$keyword%")->select(['id','name'])->limit(10)->get();
        $center = Center::query()->where('name', 'Like', "%$keyword%")->select(['id','name'])->limit(10)->get();
        $result = $product->merge($device);
        $finalResult = $result->merge($center);
        $search_results = HomeSearchResource::collection($finalResult) ;
        return apiResponse(data: $search_results);
    }

}
