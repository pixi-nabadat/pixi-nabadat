<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPackageRequest;
use App\Services\UserPackageService;
use Illuminate\Http\Request;

class UserPackageController extends Controller
{
    public function __construct(private UserPackageService $userPackageService)
    {
        
    }
    
    public function index(){
        try{
            $userPackages = $this->userPackageService->getAll();
            return apiResponse( data: $userPackages,message: trans('lang.success'));
        }
        catch(\Exception $exception){
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }//end of index


    public function store(userPackageRequest $request){
        try {
            $request->validated();
            $userPackages=$this->userPackageService->store($request->all());
            return apiResponse(data: $userPackages,message: trans('lang.success'));
        } catch (\Exception $ex) {
            return apiResponse(message: $ex->getMessage(), code: 422);
        }
    }//end of store

    public function update(userPackageRequest $request, $id)
    {
       
        try {
            $request->validated();
            $userPackages=$this->userPackageService->update($id, $request->all());
            return apiResponse(data: $userPackages,message: trans('lang.success'));
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

}
