<?php

namespace App\Http\Controllers\Api;


use App\Enum\ActivationStatusEnum;
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
            $withRelation = [
                'attachments',
                'rates' =>fn($rates)=>$rates->where('status',ActivationStatusEnum::ACTIVE)->limit(8),
                'rates.user.attachments',
            ];
            $product = $this->productService->find($id,$withRelation);
            if ($product)
                return apiResponse(data: new ProductResource($product) , message: trans('lang.success_operation'));
            return apiResponse(message: trans('lang.product_not_found'),code: 404);
        } catch (\Exception $e) {
            return apiResponse(message: $e->getMessage(), code: $e->getCode());
        }
    }
}
