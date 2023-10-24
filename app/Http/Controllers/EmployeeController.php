<?php

namespace App\Http\Controllers;

use App\DataTables\EmployeesDataTable;
use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\User;
use App\Services\EmployeeService;
use App\Services\LocationService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class EmployeeController extends Controller
{
    public function __construct(private EmployeeService $employeeService, private LocationService $locationService)
    {

    }

    public function index(EmployeesDataTable $dataTable, Request $request)
    {
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $withRelations = [] ;
        $governorateFilters = ['depth' => 1, 'is_active' => 1];
        $governorates = $this->locationService->getAll($governorateFilters);
        return $dataTable->with(['filters'=>$filters,'withRelations'=>$withRelations])->render('dashboard.employees.index', ['governorates'=>$governorates]);
    }//end of index

    public function edit($id)
    {
        $withRelation = ['attachments'];
        $employee = $this->employeeService->find($id,$withRelation);
        if (!$employee) {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.employee_not_found')];
            return back()->with('toast', $toast);
        }
        $filters = ['depth' => 1, 'is_active' => 1];
        $governorates = $this->locationService->getAll($filters);
        $permissions = Permission::all();
        $permissions = $permissions->groupBy('category');
        return view('dashboard.employees.edit', compact('employee', 'permissions', 'governorates'));
    }//end of edit

    public function create()
    {
        $permissions = Permission::all();
        $permissions = $permissions->groupBy('category');
        $filters = ['depth' => 1, 'is_active' => 1];
        $governorates = $this->locationService->getAll($filters);
        return view('dashboard.employees.create', compact('permissions', 'governorates'));
    }//end of create

    public function store(EmployeeStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $this->employeeService->store(data: $data);
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect()->route('employees.index')->with('toast', $toast);
        } catch (\Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    }//end of store

    public function update(EmployeeUpdateRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $this->employeeService->update($id, $data);
            $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect(route('employees.index'))->with('toast', $toast);
        } catch (\Exception $ex) {

            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    } //end of update

    public function destroy($id)
    {
        try {
            $result = $this->employeeService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy

    public function show($id)
    {
        $withRelations = ['attachments'];
        $employee = $this->employeeService->find($id, $withRelations);
        if (!$employee) {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.employee_not_found')];
            return back()->with('toast', $toast);
        }
        $filters = ['depth' => 1, 'is_active' => 1];
        $governorates = $this->locationService->getAll($filters);
        $permissions = Permission::all();
        $permissions = $permissions->groupBy('category');
        return view('dashboard.employees.show', compact('employee', 'permissions','governorates'));
    } //end of show

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     *
     * status method for change is_active column only
     */
    public function status(Request $request)
    {
        try {
            $result = $this->employeeService->status($request->id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of status
}
