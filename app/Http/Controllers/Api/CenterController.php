<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CenterService;
use App\Services\LocationService;
use Illuminate\Support\Facades\Auth;


class CenterController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(private CenterService $centerService,private LocationService $locationService)
    {

    }

    public function getAllLocationCenters(Request $request)
    {
        try {
            $location_id = $request->location_id ?? Auth::user()->location_id;
            $filters = ['is_active' => 1, 'location_id' => $location_id];
            $list = $this->centerService->getAll($filters);
            return apiResponse($list,__('lang.success'));
        } catch (\Exception $e) {
            return apiResponse($e->getMessage(), 'Unauthorized',$e->getCode());
        }
    }
}
