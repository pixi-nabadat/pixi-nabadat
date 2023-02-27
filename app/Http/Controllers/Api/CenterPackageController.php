<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageStoreRequest;
use App\Http\Requests\PackageUpdateRequest;
use App\Http\Resources\PackagesResource;
use App\Services\CenterPackageService;
use Exception;

class CenterPackageController extends Controller
{
    public function __construct(public CenterPackageService $packageService)
    {
    }


    public function index(): \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $filters = ['is_active' => 1, 'in_duration' => true , 'status'=>true];
            $withRelations = ['center.user:id,center_id,name','center.defaultLogo'];
            $allPackages = $this->packageService->listing(where_condition: $filters, withRelation: $withRelations);
            if(!$allPackages)
                return apiResponse(message: trans('lang.something_went_rong'), code:422);
            $packages = PackagesResource::collection($allPackages);
            return apiResponse(data: $packages, message: trans('lang.success_operation'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }

    public function store(PackageStoreRequest $request)
    {
        cache()->forget('home-api');
        try {
            $data = $request->validated();
            $package = $this->packageService->store($data);
            if(!$package)
                return apiResponse(message: trans('lang.something_went_rong'), code:422);
            $response = new PackagesResource($package);
            return apiResponse(data: $response, message: trans('lang.success_operation'), code: 200);
        } catch (\Exception $ex) {
            return apiResponse(message: trans('lang.something_went_rong'), code: 422);
        }
    }//end of store

    public function update(PackageUpdateRequest $request, $id)
    {
        cache()->forget('home-api');
        try {
            $package = $this->packageService->update($id, $request->validated());
            if(!$package)
                return apiResponse(message: trans('lang.something_went_rong'), code:422);
            $response = new PackagesResource($package);
            return apiResponse(data: $response, message: trans('lang.success_operation'), code: 200);
        } catch (\Exception $ex) {
            return apiResponse(message: $ex->getMessage(), code: 422);
        }
    } //end of update

    public function destroy($id)
    {
        cache()->forget('home-api');
        try {
            $result = $this->packageService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success_operation'), code: 200);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy

    public function show($id)
    {
        try {
            $package = $this->packageService->find($id);
            if (!$package) {
                return apiResponse(message: trans('lang.error'), code: 422);
            }
            $data = new PackagesResource($package);
            return apiResponse(data: $data, message: trans('lang.success_operation'), code: 200);
        } catch (Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    } //end of show

}
