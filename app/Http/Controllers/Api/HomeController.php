<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CancelReasonsResource;
use App\Http\Resources\CentersResource;
use App\Http\Resources\LocationsResource;
use App\Http\Resources\product\ProductsResource;
use App\Services\CancelReasonService;
use App\Services\CenterService;
use App\Services\LocationService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function __construct(protected ProductService $productService,protected CenterService $centerService,protected LocationService $locationService)
    {
    }


    public function __invoke()
    {
        $user = auth('sanctum')->user();
        if (isset($user))
            $location_id = $user->location_id ;
        else
            $location_id = request()->input('location_id');
        $data =  Cache::remember('home-api', 60*60*24, function () use ($location_id) {
          $data ['featured_products'] = ProductsResource::collection($this->productService->getAll(where_condition:['featured'=>1],withRelation: ['attachments']));
          $data ['featured_centers'] = CentersResource::collection($this->centerService->listing(filters:['featured'=>1],withRelation: ['location','attachments']));
          $data ['sliders'] = [];
          $data['locations'] = LocationsResource::collection($this->locationService->getAll(filters: ['depth'=>2]));
          return $data ;
        });

        return apiResponse(data: $data);
    }

}
