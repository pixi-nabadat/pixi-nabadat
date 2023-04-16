<?php

namespace App\Http\Controllers;

use App\DataTables\ProductsDataTable;
use App\Http\Requests\ProductRequest;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService, private CategoryService $categoryService)
    {
    }

    public function index(ProductsDataTable $dataTable, Request $request)
    {
        $loadRelation = ['user'];
        $filters = $request->filters ?? [];
        return $dataTable->with(['filters' => $filters, 'withRelations' => $loadRelation])->render('dashboard.products.index');
    } //end of index

    public function edit($id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        $withRelation = ['attachments'];
        $product = $this->productService->find($id,$withRelation);
        $categories = $this->categoryService->getAll();
        if (!$product)
        {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.product_not_found')];
            return back()->with('toast', $toast);
        }
        return view('dashboard.products.edit', compact('categories', 'product'));

    } //end of edit

    public function create()
    {
        $categories = $this->categoryService->getAll();
        return view('dashboard.products.create', compact('categories'));
    } //end of create

    public function store(ProductRequest $request)
    {
        try {
            $data = $request->validated();
            $data['added_by'] = auth()->id();
            $this->productService->store($data);
            $toast = ['type' => 'success', 'title' => trans('lang.success'), 'message' => trans('lang.Product Saved Successfully')];
            return redirect()->route('products.index')->with('toast', $toast);
        } catch (\Exception $ex) {
            $toast = ['type' => 'error', 'title' => 'error', 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    } //end of store

    public function update(ProductRequest $request, $id)
    {
        try {
            $request->validated();
            $this->productService->update($id, $request->all());
            $toast = ['title' => trans('lang.success'), 'message' => trans('lang.success_operation')];
            return redirect(route('products.index'))->with('toast', $toast);
        } catch (\Exception $ex) {

            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => $ex->getMessage(),];
            return redirect()->back()->with('toast', $toast);
        }
    } //end of update

    public function destroy($id)
    {
        try {
            $result = $this->productService->delete($id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of destroy

    public function show($id)
    {
        $withRelation = ['category:id,name','attachments'];
        $product = $this->productService->find(id: $id, withRelation: $withRelation);
        if (!$product) {
            $toast = ['type' => 'error', 'title' => trans('lang.error'), 'message' => trans('lang.Product_not_found')];
            return back()->with('toast', $toast);
        }
        return view('dashboard.products.show', compact('product'));
    } //end of show


    public function featured(Request $request)
    {
        try {
            //first forget cash
            $this->productService->featured($request->id);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of featured

    public function status(Request $request)
    {
        try {
            //first forget cash
            $result = $this->productService->status($request->id);
            if (!$result)
                return apiResponse(message: trans('lang.not_found'), code: 404);
            return apiResponse(message: trans('lang.success'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    } //end of status
}
