<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\LocationsResource;
use App\Http\Resources\product\ProductResource;
use App\Http\Resources\product\ProductsResource;
use App\Services\LocationService;
use App\Services\ProductService;
use Illuminate\Http\Request;


class LocationController extends Controller
{
    public function __construct(private LocationService $locationService)
    {
    }

    public function getAllGovernorates()
    {
        $governorates = $this->locationService->getAll(['depth'=>1]);
        return LocationsResource::collection($governorates);
    }

    public function getLocationByParentId($id)
    {
        $locations = $this->locationService->getAll(['parent_id'=>$id]);
        return LocationsResource::collection($locations);
    }
}
