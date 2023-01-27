<?php

namespace App\Http\Controllers;


use App\Http\Resources\LocationsResource;
use App\Services\LocationService;


class LocationController extends Controller
{
    public function __construct(private LocationService $locationService)
    {
    }

    public function getLocationByParentId($parent_id)
    {
        $locations =  $this->locationService->getLocationDescendants(location_id: $parent_id);;
        return LocationsResource::collection($locations);
    }
}
