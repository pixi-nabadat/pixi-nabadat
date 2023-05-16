<?php

namespace App\Http\Controllers\Api;

use App\Enum\PackageStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\PackageStoreRequestApi;
use App\Http\Requests\PackageUpdateRequest;
use App\Http\Resources\PackagesResource;
use App\Services\CenterPackageService;
use Exception;

class CenterPackageController extends Controller
{
    public function __construct(public CenterPackageService $packageService)
    {
        $this->middleware('auth:sanctum')->except('index');
    }

    public function index(): \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $filters = ['is_active' => 1, 'in_duration' => true , 'status' =>PackageStatusEnum::APPROVED];
            $withRelations = ['center.defaultLogo','attachments'];
            $allPackages = $this->packageService->listing(where_condition: $filters, withRelation: $withRelations);
            return PackagesResource::collection($allPackages);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }

    public function store(PackageStoreRequestApi $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $data = $request->validated();
            $package = $this->packageService->store($data);
            if(!$package)
                return apiResponse(message: trans('lang.there_is_problem_when_create_offer'), code:422);
            $response = new PackagesResource($package);
            return apiResponse(data: $response, message: trans('lang.success_operation'), code: 200);
        } catch (\Exception $ex) {
            return apiResponse(message: $ex->getMessage(), code: 500);
        }
    }//end of store

    public function update(PackageUpdateRequest $request, $id): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $package = $this->packageService->update($id, $request->validated());
            $response = new PackagesResource($package);
            return apiResponse(data: $response, message: trans('lang.success_operation'), code: 200);
        } catch (\Exception $ex) {
            return apiResponse(message: $ex->getMessage(), code: 422);
        }
    } //end of update

    public function destroy($id): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
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

    public function show($id): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $package = $this->packageService->find($id);
            $data = new PackagesResource($package);
            return apiResponse(data: $data, message: trans('lang.success_operation'));
        } catch (Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    } //end of show

}
