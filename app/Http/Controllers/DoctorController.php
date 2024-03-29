<?php

namespace App\Http\Controllers;

use App\DataTables\DoctorsDataTable;
use App\Http\Requests\DoctorStoreRequest;
use App\Http\Requests\DoctorUpdateRequest;
use App\Services\CenterService;
use App\Services\DoctorService;
use App\Services\LocationService;
use Illuminate\Http\Request;

class DoctorController extends Controller
{

    public function __construct(private DoctorService $doctorService, private LocationService $locationService)
    {
    }

    public function index(DoctorsDataTable $dataTable, Request $request)
    {
        userCan(request: $request, permission: 'view_doctor');
        $loadRelation = ['center.user:id,name,center_id'];
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        return $dataTable->with(['filters' => $filters, 'withRelations' => $loadRelation])->render('dashboard.doctors.index');
    } //end of index

    public function create(Request $request)
    {
        userCan(request: $request, permission: 'create_doctor');
        $withRelations = ['user:id,name,center_id'];
        $centers = app()->make(CenterService::class)->getAll(withRelations: $withRelations);
        return view('dashboard.doctors.create', compact('centers'));
    } //end of create


    public function show($id)
    {
//        $user = User::find($id);
//        $filter = ['depth' => 1];
//        $governorates = (new LocationService())->getAll($filter);
//        return view('dashboard.Doctors.show', compact('user', 'governorates'));
    } //end of show

    public function edit(Request $request, $id)
    {
        userCan(request: $request, permission: 'edit_doctor');
        $doctor = $this->doctorService->find($id);
        if (!$doctor) {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.doctor_not_found')];
            return back()->with('toast', $toast);
        }
        $withRelations = ['user:id,name,center_id'];
        $centers = app()->make(CenterService::class)->getAll(withRelations: $withRelations);
        return view('dashboard.doctors.edit', compact('doctor', 'centers'));
    } //end of edit

    public function store(DoctorStoreRequest $request)
    {
        userCan(request: $request, permission: 'create_doctor');
        try {
            $data = $request->validated();
            $this->doctorService->store($data);
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'Doctor Saved Successfully'];
            return redirect()->route('doctors.index')->with('toast', $toast);
        } catch (\Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    } //end of store

    public function update(DoctorUpdateRequest $request, $id)
    {
        userCan(request: $request, permission: 'edit_doctor');
        try {
            $data = $request->validated();
            $this->doctorService->update($id, $data);
            $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect(route('doctors.index'))->with('toast', $toast);
        } catch (\Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        userCan(request: $request, permission: 'delete_doctor');
        try {
            $result = $this->doctorService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy
    public function status(Request $request)
    {
        try {
            $result = $this->doctorService->status($request->id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of status
}
