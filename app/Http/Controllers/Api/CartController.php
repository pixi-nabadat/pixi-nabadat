<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartStoreRequest;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Resources\CartsResource;
use App\Services\CartService;
use Exception;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(private CartService $cartService)
    {
    }

    public function store(CartStoreRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $relation = ['user'];
            $cart = $this->cartService->store($request->validated(), $relation);
            $cart = new CartsResource($cart);
            return apiResponse(data: $cart, message: 'Success', code: 200);
        } catch (Exception $ex) {
            return apiResponse(data: null, message: $ex->getMessage(), code: 422);
        }
    }
}
