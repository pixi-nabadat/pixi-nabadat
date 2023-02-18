<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CenterDeviceStoreRequest;
use App\Http\Requests\CenterDeviceUpdateRequest;
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
            $centerDevices = $this->centerDeviceService->getAllCenterDevices(id: $request->id);
            $response = CenterDevicesResource::collection($centerDevices);
            return apiResponse(data: $response, message: trans('lang.success_operation'));
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
            $centerDevices = $this->centerDeviceService->store($request->validated());
            return apiResponse(data: CenterDevicesResource::collection($centerDevices), message: trans('lang.success_operation'));
        } catch (Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }


    public function update(CenterDeviceUpdateRequest $request, $id)
    {
        try {
            $this->centerDeviceService->update($id, $request->validated());
            return apiResponse(message: trans('lang.updated_successfully'));
        } catch (\Exception $ex) {
            return apiResponse(message: trans('lang.there_is_an_error'),code: 400);
        }
    } //end of update

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
