<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\LocationsResource;
use App\Services\LocationService;


class LocationController extends Controller
{
    public function __construct(private LocationService $locationService)
    {
    }

    public function getAllGovernorates(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $governorates = $this->locationService->getAll(['depth' => 1]);
        return LocationsResource::collection($governorates);
    }

    public function getLocationByParentId($id): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $locations = $this->locationService->getLocationDescendants(location_id: $id);
        return LocationsResource::collection($locations);
    }
}
