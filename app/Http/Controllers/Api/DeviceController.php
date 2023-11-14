<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeviceResource;
use App\Services\DeviceService;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(private DeviceService $deviceService)
    {

    }

    // listing all devices
    public function listing(Request $request): \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $withRelations = ['defaultImage'];
            $where_condition = ['is_active=>1'];
            $devices = $this->deviceService->getAll(where_condition: $withRelations);
            return apiResponse(data: DeviceResource::collection($devices), message: trans('lang.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }
}
