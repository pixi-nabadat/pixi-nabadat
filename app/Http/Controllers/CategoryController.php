<?php

namespace App\Http\Controllers;

use App\DataTables\CategoriesDataTable;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {

    }

    public function index(CategoriesDataTable $dataTable, Request $request){

        $filters = array_filter($request->get('filters', []), function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $withRelations = [];
        return $dataTable->with(['filters'=>$filters, 'withRelations'=>$withRelations])->render('dashboard.categories.index');

    }//end of index

    public function edit($id){
        $category = $this->categoryService->find($id);
        if (!$category)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.category_not_found')];
            return back()->with('toast', $toast);
        }
        return view('dashboard.categories.edit', compact('category'));
    }//end of edit

    public function create(){
        return view('dashboard.categories.create');
    }//end of create

    public function store(CategoryRequest $request){
        try {
            $this->categoryService->store($request->validated());
            $toast = ['type' => 'success', 'title' => 'Success', 'message' => 'category Saved Successfully'];
            return redirect()->route('categories.index')->with('toast', $toast);
        } catch (\Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    }//end of store

    public function update(CategoryRequest $request, $id)
    {
        try {
            $this->categoryService->update($id, $request->validated());
            $toast = ['title' => 'Success', 'message' => trans('lang.success_operation')];
            return redirect(route('categories.index'))->with('toast', $toast);
        } catch (\Exception $ex) {

            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    } //end of update

    public function destroy($id)
    {
        try {
            $result = $this->categoryService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy

    public function show($id)
    {
        $category = $this->categoryService->find($id);
        if (!$category)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.category_not_found')];
            return back()->with('toast', $toast);
        }
       return view('dashboard.categories.show', compact('category'));
    } //end of show

    public function changeStatus(Request $request)
    {
        try {
            $result =  $this->categoryService->changeStatus($request->id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }

    } //end of changeStatus
}
