<?php

namespace App\Http\Controllers\Api;

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

    
    public function destroy($id){
        try{
            $relations = ['user', 'items'];
            $cart = $this->cartItemService->destroy($id, $relations);
            if($cart){
                $cart = new CartsResource($cart);
                return apiResponse(data: $cart, message: 'Item Deleted', code: 200);
            }else
                return apiResponse(data: null, message: 'Something went rong', code: 422);
        }catch(Exception $e){
            return apiResponse(data: null, message: $e->getMessage(), code: 422);
        }
    }
}
