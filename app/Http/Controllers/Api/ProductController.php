<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\product\ProductResource;
use App\Http\Resources\product\ProductsResource;
use App\Services\ProductService;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function __construct(private ProductService $productService)
    {
    }

    public function listing(Request $request): \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $filters = $request->all();
            $filters ['is_active'] = 1;
            $withRelation = ['attachments'];
            $products = $this->productService->listing($filters,$withRelation);
            return ProductsResource::collection($products);
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: $e->getCode());
        }
    }

    public function show($id): \Illuminate\Http\Response|ProductResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $withRelation = ['attachments'];
            $product = $this->productService->find($id,$withRelation);
            if ($product)
                return new ProductResource($product);
            return apiResponse(message: trans('lang.product_not_found'),code: 404);
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: $e->getCode());
        }
    }
}
