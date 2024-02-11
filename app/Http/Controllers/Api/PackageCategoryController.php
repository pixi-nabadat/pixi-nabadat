<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\PackageCategoriesResource;
use App\Services\PackageCategoryService;
use Illuminate\Http\Request;


class PackageCategoryController extends Controller
{
    public function __construct(private PackageCategoryService $packageCategoryService)
    {
    }

    public function listing(Request $request)
    {
        try {
            $filters = ['is_active' => 1];
            $withRelations = ['attachments'];
            $categories = $this->packageCategoryService->getAll($filters,$withRelations);
            return PackageCategoriesResource::collection($categories);
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: $e->getCode());
        }
    }
}
