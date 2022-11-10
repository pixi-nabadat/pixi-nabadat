<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriesResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    public function listing(Request $request)
    {
        try {
            $filters = ['is_active' => 1];
            $withRelations = ['attachments'];
            $categories = $this->categoryService->getAll($filters,$withRelations);
            return CategoriesResource::collection($categories);
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: $e->getCode());
        }
    }
}
