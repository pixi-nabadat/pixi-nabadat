<?php

namespace App\Http\Controllers;

use App\DataTables\UserPackagesDataTable;
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

    public function index(Request $request, UserPackagesDataTable $dataTable)
    {
        $withRelations = ['user','center'];
        $filters = $request->all();
        return $dataTable->with(['filters'=>$filters , 'withRelations' => $withRelations])->render('dashboard.userPackages.index');
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
            if($userPackage){
                $userPackage = new UserPackagesResource($userPackage);
                return apiResponse(data: $userPackage, message: trans('lang.operation_success'), code: 200);
            }else
                return apiResponse(data: null, message: trans('lang.error_has_occurred'), code: 422);

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
            if (!$result['status'])
                return apiResponse(message: $result['message'], code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy
}