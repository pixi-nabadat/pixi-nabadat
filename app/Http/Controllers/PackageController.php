<?php

namespace App\Http\Controllers;

use App\DataTables\PackagesDataTable;
use App\Http\Requests\PackageStoreRequest;
use App\Http\Requests\PackageUpdateRequest;
use App\Services\CenterService;
use App\Services\PackageService;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function __construct(private PackageService $packageService, private CenterService $centerService)
    {

    }

    public function index(PackagesDataTable $dataTable, Request $request)
    {
        $filters = $request->all();
        $withRelations = ['center'] ;
        return $dataTable->with(['filters'=>$filters,'withRelations'=>$withRelations])->render('dashboard.packages.index');
    }//end of index

    public function edit($id)
    {
        $withRelation = ['attachments','center'];
        $package = $this->packageService->find($id,$withRelation);
        if (!$package) {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.package_not_found')];
            return back()->with('toast', $toast);
        }
        return view('dashboard.packages.edit', compact('package'));
    }//end of edit

    public function create()
    {
        $centers = $this->centerService->getAll();
        return view('dashboard.packages.create', compact('centers'));
    }//end of create

    public function store(PackageStoreRequest $request)
    {
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

    public function destroy($id)
    {
        try {
            $result = $this->packageService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy

    public function show($id)
    {
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
