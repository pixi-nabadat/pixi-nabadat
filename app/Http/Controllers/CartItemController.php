<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartItemStoreRequest;
use App\Http\Resources\CartItemsResource;
use App\Http\Resources\CartsResource;
use App\Models\CartItem;
use App\Services\CartItemService;
use Exception;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    public function __construct(private CartItemService $cartItemService)
    {
    }

    public function store(CartItemStoreRequest $request){
        try {
            $relations = ['user', 'items'];
            $cart      = $this->cartItemService->store($request->validated(), $relations);
            return $cart;
            $cart      = new CartsResource($cart);
            return apiResponse(data: $cart, message: 'Done', code: 422);
        } catch (Exception $e) {
            return apiResponse(data: null, message: $e->getMessage(), code: 422);
        }
    }//end of store
}
