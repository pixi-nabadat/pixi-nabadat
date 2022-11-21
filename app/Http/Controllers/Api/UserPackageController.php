<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPackageRequest;
use App\Services\UserPackageService;
use App\Http\Resources\UserPackagesResource;

class UserPackageController extends Controller
{
    public function __construct(private UserPackageService $userPackageService)
    {
        
    }
    
    public function index(){
        try{
            $userPackages = $this->userPackageService->getAll();
            return UserPackagesResource::collection($userPackages);
        }
        catch(\Exception $exception){
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }//end of index


    public function store(UserPackageRequest $request){
        try {
            $userPackages=$this->userPackageService->store($request->validated());
            return apiResponse(data: $userPackages,message: trans('lang.userPackage_saved_successfully'));
        } catch (\Exception $ex) {
            return apiResponse(message: $ex->getMessage(), code: 422);
        }
    }//end of store

    public function update(UserPackageRequest $request, $id)
    {
        try {
            $userPackages=$this->userPackageService->update($id, $request->validated());
            return apiResponse(data: $userPackages,message: trans('lang.userPackage_updated_successfully'));
        } catch (\Exception $ex) {
            return apiResponse(message: $ex->getMessage(), code: 422);
        }   
    } //end of update
    
    public function destroy($id)
    {
        try {
            $result = $this->userPackageService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy


    public function find($id)
    {
        try {
            $userPackage = $this->userPackageService->find($id);
            return new UserPackagesResource($userPackage);
        } catch (\Exception $ex) {
            return apiResponse(message: $ex->getMessage(), code: 422);
        }
    }

}
