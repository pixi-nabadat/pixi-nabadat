<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageStoreRequest;
use App\Http\Requests\PackageUpdateRequest;
use App\Http\Resources\PackagesResource;
use App\Services\packageService;
use Exception;
use Illuminate\Support\Facades\Request;

class CenterPackageController extends Controller
{
    public function __construct(private packageService $packageService)
    {
    }


    public function index(): \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $filters = ['is_active' => 1];
            $allPackages = $this->packageService->getAll(where_condition: $filters);
            $data = PackagesResource::collection($allPackages);
            return apiResponse(data: $data, message: trans('lang.success_operation'), code: 200);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }

    public function store(PackageStoreRequest $request){
        try {
            $data = $request->validated();
            $package = $this->packageService->store($request->all());
            $data = new PackagesResource($package);
            return apiResponse(data: $data, message: trans('lang.success_operation'), code: 200);
        } catch (\Exception $ex) {
            return apiResponse( message: $ex->getMessage(), code: 422);
        }
    }//end of store

    public function update(PackageUpdateRequest $request, $id)
    {
        try {
            $request->validated();
            $package = $this->packageService->update($id, $request->all());
            $data = new PackagesResource($package);
            return apiResponse(data: $data, message: trans('lang.success_operation'), code: 200);
        } catch (\Exception $ex) {
            return apiResponse(message: $ex->getMessage(), code: 422);
        }
    } //end of update
    
    public function destroy($id)
    {
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
        try{
            $package = $this->packageService->find($id);
            if (!$package){
                return apiResponse(message: trans('lang.error'), code: 422);
            }
            $data = new PackagesResource($package);
            return apiResponse(data: $data, message: trans('lang.success_operation'), code: 200);
        }catch(Exception $e)
        {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    } //end of show   

}
