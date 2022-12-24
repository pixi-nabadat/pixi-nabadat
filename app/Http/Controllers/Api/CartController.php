<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartStoreRequest;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Resources\CartResource;
use App\Http\Resources\CartsResource;
use App\Services\CartService;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{


    public function __construct(protected CartService $cartService)
    {
    }

    public function index(Request $request)
    {
        try {
            $cart =  $this->cartService->getCart($request->temp_user_id);
            return new CartResource($cart) ;
        }catch (Exception $exception)
        {
            return apiResponse(message: $exception->getMessage());
        }
    }

    public function empty()
    {
        try {
            if ($this->cartService->emptyCart(request()->temp_user_id))
                return apiResponse(message: trans('lang.cart_empty'));
            else
                return apiResponse(message: trans('lang.error_has_occurred'));
        } catch (Exception $ex) {
            return apiResponse(message: $ex->getMessage());
        }
    }

    public function deleteCartItem($id): \Illuminate\Http\Response|CartResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $cart = $this->cartService->removeItem($id, request()->temp_user_id);
            return new CartResource($cart);
        } catch (Exception $ex) {
            return apiResponse(message: $ex->getMessage());
        }
    }

    public function store(CartStoreRequest $request,ProductService $productService)
    {
        try {
            DB::beginTransaction();
            $product = $productService->find($request->product_id);
            if (!isset($product))
                return apiResponse(message: trans('lang.product_not_found'));
            if ($request->quantity < 1)
                return apiResponse(message: trans('lang.quantity_is_more_than_stock_available'). $product->stock);

            if ($request->quantity > $product->stock)
                return apiResponse(message: trans('lang.quantity_is_more_than_stock_available'). $product->stock);

            $cart = $this->cartService->addItem(product_id: $request->product_id,quantity: $request->quantity, temp_user_id: $request->temp_user_id);
            DB::commit();
            return new CartResource($cart);
        } catch (Exception $ex) {
            DB::rollBack();
            return apiResponse(message: $ex->getMessage());
        }
    }
}
