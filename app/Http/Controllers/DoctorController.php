<?php

namespace App\Http\Controllers;

use App\DataTables\DoctorsDataTable;
use App\DataTables\UsersDataTable;
use App\Http\Requests\DoctorStoreRequest;
use App\Http\Requests\DoctorUpdateRequest;
use App\Models\Location;
use App\Models\User;
use App\Services\LocationService;
use App\Services\UserService;
use Illuminate\Http\Request;

class DoctorController extends Controller
{

    public function __construct(private UserService $userService,private LocationService $locationService)
    {
    }

    public function index(DoctorsDataTable $dataTable, Request $request)
    {
        $request = $request->merge(['type' => User::DOCTORTYPE]); //filter Doctor users
        return $dataTable->with(['filters' => $request->all()])->render('dashboard.Doctors.index');
    } //end of index

    public function create()
    {
        $filters = ['governorates_filter'=>['depth' => 1],'city_filter'=>['depth' => 2]];
        $governorates = $this->locationService->getAll($filters['governorates_filter']);
        $cities = $this->locationService->getAll($filters['city_filter']);
        return view('dashboard.Doctors.create', compact('governorates','cities'));
    } //end of create


    public function show($id)
    {
//        $user = User::find($id);
//        $filter = ['depth' => 1];
//        $governorates = (new LocationService())->getAll($filter);
//        return view('dashboard.Doctors.show', compact('user', 'governorates'));
    } //end of show

    public function edit($id)
    {
        $user = $this->userService->find($id);
        if (!$user)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.doctor_not_found')];
            return back()->with('toast', $toast);
        }
        $filter = ['depth' => 1];
        $governorates = $this->locationService->getAll($filter);
        return view('dashboard.Doctors.edit', compact('user', 'governorates'));
    } //end of edit

    public function store(DoctorStoreRequest $request)
    {
        try {
            $request->validated();
            $request->merge(['type'=>User::DOCTORTYPE]);
            $this->userService->store($request->all());
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'Doctor Saved Successfully'];
            return redirect()->route('doctors.index')->with('toast', $toast);
        } catch (\Exception $ex) {

            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    } //end of store

    public function update(DoctorUpdateRequest $request, $id)
    {

        try {
            $request->validated();
            $request['type'] = User::DOCTORTYPE;
            $this->userService->update($id, $request->all());
            $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect(route('doctors.index'))->with('toast', $toast);
        } catch (\Exception $ex) {

            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    } //end of update

    public function destroy($id)
    {
        try {
            $result = $this->userService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy

    public function changeStatus($id)
    {
        $this->userService->changeStatus($id);
        $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
        return redirect(route('doctors.index'))->with('toast', $toast);
    } //end of changeStatus

}
