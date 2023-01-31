<?php

namespace App\Http\Controllers;

use App\DataTables\RolesDataTable;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(RolesDataTable $dataTable)
    {
        return $dataTable->render('dashboard.roles.index');
    } //end of index


    public function create()
    {
        return view('dashboard.roles.create');
    } //end of create

    public function store(Request $request)
    {
        try {
            $role = Role::create(['name' => $request->name]);
            $toast = ['type' => 'success', 'title' => trans('lang.success'), 'message' => trans('lang.role_saved_successfully')];
            return redirect()->route('roles.index')->with('toast', $toast);
        } catch (Exception $e) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $e->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }

    }

    public function destroy($id)
    {
        try {
            $role = Role::find($id);
            $role->delete();
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy

    public function assignPermissionsToRole(Request $request, Role $role)
    {
        try {
            $role->givePermissionTo($request->permission);
            $toast = ['type' => 'success', 'title' => trans('lang.success'), 'message' => trans('lang.operation_success')];
            return redirect()->route('roles.index')->with('toast', $toast);
        } catch (Exception $e) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $e->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    }

    public function removeRolePermission(Request $request, Role $role)
    {

        try {
            $role->revokePermissionTo($request->permission);
            $toast = ['type' => 'success', 'title' => trans('lang.success'), 'message' => trans('lang.operation_success')];
            return redirect()->route('roles.index')->with('toast', $toast);
        } catch (Exception $e) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $e->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    }
}
