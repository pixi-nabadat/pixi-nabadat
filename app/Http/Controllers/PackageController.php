<?php

namespace App\Http\Controllers;

use App\DataTables\PackagesDataTable;
use App\Http\Requests\PackageStoreRequest;
use App\Http\Requests\PackageUpdateRequest;
use App\Models\Center;
use App\Services\CenterService;
use App\Services\CenterPackageService;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function __construct(private CenterPackageService $packageService, private CenterService $centerService)
    {

    }

    public function index(PackagesDataTable $dataTable, Request $request)
    {
        userCan(request: $request, permission: 'view_package');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $withRelations = ['center'] ;
        $centers = Center::all();
        return $dataTable->with(['filters'=>$filters,'withRelations'=>$withRelations])->render('dashboard.packages.index', ['centers'=>$centers]);
    }//end of index

    public function edit(Request $request, $id)
    {
        userCan(request: $request, permission: 'edit_package');
        $withRelation = ['attachments','center'];
        $package = $this->packageService->find($id,$withRelation);
        if (!$package) {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.package_not_found')];
            return back()->with('toast', $toast);
        }
        $centers = $this->centerService->getAll();
        return view('dashboard.packages.edit', compact('package', 'centers'));
    }//end of edit

    public function create(Request $request)
    {
        userCan(request: $request, permission: 'create_package');
        $centers = $this->centerService->getAll();
        return view('dashboard.packages.create', compact('centers'));
    }//end of create

    public function store(PackageStoreRequest $request)
    {
        userCan(request: $request, permission: 'create_package');
        try {
            $request->validated();
            $this->packageService->store($request->all());
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'package Saved Successfully'];
            return redirect()->route('packages.index')->with('toast', $toast);
        } catch (\Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    }//end of store

    public function update(PackageUpdateRequest $request, $id)
    {
        userCan(request: $request, permission: 'edit_package');
        try {
            $data = $request->validated();
            $this->packageService->update($id, $data);
            $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect(route('packages.index'))->with('toast', $toast);
        } catch (\Exception $ex) {

            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        userCan(request: $request, permission: 'delete_package');
        try {
            $result = $this->packageService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy

    public function show(Request $request, $id)
    {
        userCan(request: $request, permission: 'view_package');
        $package = $this->packageService->find($id);
        if (!$package) {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.package_not_found')];
            return back()->with('toast', $toast);
        }
        return view('dashboard.packages.show', compact('package'));
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
            $result = $this->packageService->status($request->id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of status
}
