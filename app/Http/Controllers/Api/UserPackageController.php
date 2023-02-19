<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Exceptions\NotFoundHttpException;
use App\Exceptions\StatusNotEquelException;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\ReservationStoreRequest;
use App\Http\Requests\ReservationUpdateRequest;
use App\Http\Requests\UserPackageStoreRequest;
use App\Http\Requests\UserPackageUpdateRequest;
use App\Http\Resources\CentersResource;
use App\Http\Resources\ReservationsResource;
use App\Http\Resources\UserPackagesResource;
use Carbon\Carbon;
use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Validation\Rules\Unique;
use App\Models\User;
use App\Services\UserPackageService;
use Illuminate\Support\Facades\Auth;

class UserPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(private UserPackageService $userPackageService)
    {

    }

    public function userPackagesListing(Request $request): \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $filters = $request->all();
            $filters['user_type'] = User::CUSTOMERTYPE;
            $filters['user_id']   = auth()->id();
            $withRelations = ['center:id,description,address','center.defaultLogo','center.user:id,center_id,name','package'];
            $userPackages = $this->userPackageService->listing(filters: $filters,withRelation: $withRelations);
            return UserPackagesResource::collection($userPackages);
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

    public function centerPackagesListing(Request $request): \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $filters = $request->all();
            $filters['user_type'] = 'center';
            $filters['center_id'] = auth()->user()->center_id;
            $withRelations = ['package','user'];
            $userPackages = $this->userPackageService->listing(filters: $filters,withRelation: $withRelations);
            return UserPackagesResource::collection($userPackages);
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function find(int $id)
    {
        try{
            $withRelations = [];
            $userPackage = $this->userPackageService->find($id,$withRelations);
            $userPackage = new UserPackagesResource($userPackage);
            return apiResponse(data: $userPackage, message: trans('lang.operation_success'), code: 200);
        }catch(Exception $e){
            return apiResponse(message:  $e->getMessage(), code: 422);
        }
    }

    /**
     * @param UserPackageUpdateRequest $userPackageUpdateRequest
     * @return UserPackagesResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(int $id, UserPackageUpdateRequest $userPackageUpdateRequest)
    {
        try{
            $userPackage = $this->userPackageService->update($id, $userPackageUpdateRequest->validated());
            return new UserPackagesResource($userPackage);
        }catch(Exception $e){
            return apiResponse(message: $e->getMessage(), code: 422);
        }
    }

    /**
     * distory the user package
     * @param int $id
     */
    public function destroy(int $id)
    {
        try {
            $result = $this->userPackageService->delete($id);
            if (!$result)
                return apiResponse(message: trans('there_is_an_error'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy
}
