<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CenterDeviceStoreRequest;
use App\Http\Requests\CenterDeviceUpdateRequest;
use App\Http\Resources\CenterDeviceResource;
use App\Http\Resources\DeviceResource;
use App\Services\CenterDeviceService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

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
            if (is_null($center_id))
                throw new UnauthorizedException('unauthorized');
            $centerDevices = $this->centerDeviceService->getAllCenterDevices(id: $center_id);
            return CenterDeviceResource::collection($centerDevices);
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
            $centerDevice = $this->centerDeviceService->store($request->validated());
            if(!$centerDevice)
                return apiResponse(message: trans('lang.something_went_rong'), code: 422);
            return apiResponse( message: trans('lang.success_operation'));
        } catch (Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

    public function update(int $id,CenterDeviceUpdateRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $centerDevice = $this->centerDeviceService->update(id: $id, data: $request->validated());
            if(!$centerDevice)
                return apiResponse(message: trans('lang.not_found'), code: 422);
            $response = new CenterDeviceResource($centerDevice);
            return apiResponse(data: $response, message: trans('lang.success_operation'));
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

    public function autoService(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $this->centerDeviceService->supportAutoService($request->id);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of autoService

    public function status(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $this->centerDeviceService->status($request->id);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of status
}
