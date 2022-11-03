<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    public function getAllCategories(Request $request)
    {
        try {
            $filters = ['is_active' => 1];
            $list = $this->categoryService->getAll($filters);
            return apiResponse($list, __('lang.success'));
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: $e->getCode());
        }
    }
}
