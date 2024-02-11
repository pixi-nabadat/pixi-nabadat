<?php

namespace App\Http\Controllers;

use App\DataTables\PackageCategoriesDataTable;
use App\Http\Requests\PackageCategoryRequest;
use App\Services\PackageCategoryService;
use Illuminate\Http\Request;

class PackageCategoryController extends Controller
{
    public function __construct(private PackageCategoryService $packageCategoryService)
    {

    }

    public function index(PackageCategoriesDataTable $dataTable, Request $request)
    {
        userCan(request: $request, permission: 'view_package_category');
        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $withRelations = [];
        return $dataTable->with(['filters'=>$filters, 'withRelations'=>$withRelations])->render('dashboard.package-categories.index');

    }//end of index

    public function edit(Request $request, $id)
    {
        userCan(request: $request, permission: 'edit_package_category');
        $packageCategory = $this->packageCategoryService->find($id);
        if (!$packageCategory)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.category_not_found')];
            return back()->with('toast', $toast);
        }
        return view('dashboard.package-categories.edit', compact('packageCategory'));
    }//end of edit

    public function create(Request $request)
    {
        userCan(request: $request, permission: 'create_package_category');
        return view('dashboard.package-categories.create');
    }//end of create

    public function store(PackageCategoryRequest $request)
    {
        userCan(request: $request, permission: 'create_package_category');
        try {
            $this->packageCategoryService->store($request->validated());
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect()->route('package-categories.index')->with('toast', $toast);
        } catch (\Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    }//end of store

    public function update(PackageCategoryRequest $request, $id)
    {
        userCan(request: $request, permission: 'edit_package_category');
        try {
            $this->packageCategoryService->update($id, $request->validated());
            $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect(route('package-categories.index'))->with('toast', $toast);
        } catch (\Exception $ex) {

            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        userCan(request: $request, permission: 'delete_package_category');
        try {
            $result = $this->packageCategoryService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy

    public function show(Request $request, $id)
    {
        userCan(request: $request, permission: 'view_package_category');
        $packageCategory = $this->packageCategoryService->find($id);
        if (!$packageCategory)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.category_not_found')];
            return back()->with('toast', $toast);
        }
       return view('dashboard.package-categories.show', compact('packageCategory'));
    } //end of show

    public function changeStatus(Request $request)
    {
        try {
            $result =  $this->packageCategoryService->changeStatus($request->id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }

    } //end of changeStatus
}
