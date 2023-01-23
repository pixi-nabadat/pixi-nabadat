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
use App\Http\Requests\UserPA;
use App\Http\Requests\UserPackageUpdateRequest;
use App\Http\Resources\CentersResource;
use App\Http\Resources\ReservationsResource;
use App\Http\Resources\UserPackagesResource;
use Carbon\Carbon;
use App\Models\Reservation;
use App\Services\ReservationService;
use Illuminate\Validation\Rules\Unique;
use App\Models\User;
use App\Services\CenterService;
use App\Services\PackageService;
use App\Services\UserPackageService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class UserPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(private UserPackageService $userPackageService, private CenterService $centerService, private UserService $userService, private PackageService $packageService)
    {

    }

    public function index(Request $request, UserPackagesDataTable $dataTable)
    {
        $withRelations = ['user','center'];
        $filters = $request->all();
        return $dataTable->with(['filters'=>$filters , 'withRelations' => $withRelations])->render('dashboard.userPackages.index');
    }

    public function create()
    {
        $users = $this->userService->getAll();
        $centers = $this->centerService->getAll();
        return view('dashboard.userPackages.create', compact(['centers', 'users']));
    }//end of create

    public function show($id)
    {
        $userPackage = $this->userPackageService->find($id);
        if (!$userPackage) {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.user_package_not_found')];
            return back()->with('toast', $toast);
        }
        return view('dashboard.userPackages.show', compact('userPackage'));
    } //end of show

    public function edit(int $id)
    {
        $userPackage = $this->userPackageService->find($id);
        if (!$userPackage) {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.user_package_not_found')];
            return back()->with('toast', $toast);
        }
        $users = $this->userService->getAll();
        $centers = $this->centerService->getAll();
        return view('dashboard.userPackages.edit', compact(['userPackage', 'users', 'centers']));
    } //end of show
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
    public function store(UserPackageStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $this->userPackageService->store($data);
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => trans('lang.operation_success')];
            return redirect()->route('userPackages.index')->with('toast', $toast);
        } catch (\Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    }
     /**
     * @param UserPackageUpdateRequest $userPackageUpdateRequest
     * @return UserPackagesResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(int $id, UserPackageUpdateRequest $request)
    {
        try {
            $data = $request->validated();
            $this->userPackageService->update($id, $data);
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => trans('lang.operation_success')];
            return redirect()->route('userPackages.index')->with('toast', $toast);
        } catch (\Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    }
    /**
     * distory the user package
     * @param int $id
     */
    public function destroy(int $id)
    {
        try {
            $this->userPackageService->delete($id);
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => trans('lang.operation_success')];
            return redirect()->route('userPackages.index')->with('toast', $toast);
        } catch (\Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    } //end of destroy
}
