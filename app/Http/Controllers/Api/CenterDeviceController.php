<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CenterDeviceStoreRequest;
use App\Http\Resources\DeviceResource;
use App\Services\CenterDeviceService;
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

    public function listing(): \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $center_id = auth()->user()->center_id;
            $centerWithDevices = $this->centerDeviceService->getAllCenterDevices(id: $center_id);
            $response = DeviceResource::collection($centerWithDevices->devices);
            return apiResponse(data: $response, message: trans('lang.success_operation'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

    /**
     * @param CenterDeviceStoreRequest $request
     * @return \Illuminate\Http\Response|DeviceResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function store(CenterDeviceStoreRequest $request): \Illuminate\Http\Response|DeviceResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $centerDevices = $this->centerDeviceService->store($request->validated());
            return apiResponse(data: DeviceResource::collection($centerDevices), message: trans('lang.success_operation'));
        } catch (Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

    public function destroy($id)
    {
        try {
            $this->centerDeviceService->delete($id);
            return apiResponse(message: trans('lang.success_operation'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy

    public function autoService(Request $request)
    {
        try {
            $result = $this->centerDeviceService->supportAutoService($request->id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of autoService

    public function status(Request $request)
    {
        try {
            $result = $this->centerDeviceService->status($request->id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of status

}
