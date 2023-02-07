<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CenterDeviceStoreRequest;
use App\Http\Resources\CenterDevicesResource;
use App\Services\CenterDeviceService;
use App\Services\CenterService;
use App\Services\DeviceService;
use Exception;
use Illuminate\Http\Request;

class CenterDeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(private CenterDeviceService $centerDeviceService)
    {

    }

    // listing all reservations for logged in center
    public function listing(Request $request): \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $filters = $request->all();
            if (auth('sanctum')->user()->center_id == null)
                throw new NotFoundException('route not found');
            $withRelations = [];
            $centerDevices = $this->centerDeviceService->getAll(where_condition: $filters, withRelation: $withRelations);
            return apiResponse(data: CenterDevicesResource::collection($centerDevices), message: trans('lang.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

    /**
     * @param CenterDeviceStoreRequest $request
     * @return CenterDevicesResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(CenterDeviceStoreRequest $request): \Illuminate\Http\Response|CenterDevicesResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $centerDevice = $this->centerDeviceService->store($request->validated());
            return apiResponse(data: new CenterDevicesResource($centerDevice), message: trans('lang.success_operation'));
        } catch (Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

    public function destroy($id)
    {
        try {
            $result = $this->centerDeviceService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success_operation'), code: 200);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy

}
