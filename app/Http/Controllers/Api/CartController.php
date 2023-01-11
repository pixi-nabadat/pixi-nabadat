<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApplyCouponRequest;
use App\Http\Requests\CartStoreRequest;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateCartAddressRequest;
use App\Http\Resources\CartResource;
use App\Http\Resources\CartsResource;
use App\Services\CartService;
use App\Services\CouponService;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{


    public function __construct(protected CartService $cartService,protected CouponService $couponService)
    {
    }

    public function index(Request $request)
    {
        try {
            $cart =  $this->cartService->getCart($request->temp_user_id);
            return apiResponse(data: new CartResource($cart)) ;
        }catch (Exception $exception)
        {
            return apiResponse(message: $exception->getMessage(),code: 422);
        }
    }

    public function empty(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
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
            return apiResponse(data: new CartResource($cart));
        } catch (Exception $ex) {
            return apiResponse(message: $ex->getMessage(),code: 422);
        }
    }

    public function store(CartStoreRequest $request,ProductService $productService): \Illuminate\Http\Response|CartResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
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

    public function applyCoupon(ApplyCouponRequest $request): \Illuminate\Http\Response|CartResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $cart = $this->cartService->applyCouponOnCart($data);
            if (!$cart)
                return apiResponse(message:trans('lang.coupon_not_available'), code: 422);
            $cart = $this->cartService->getCart($data['temp_user_id']);
            DB::commit();
            return apiResponse(data: new CartResource($cart) , message: trans('lang.coupon_applied_successfully'));
        }catch (Exception $exception)
        {
            return  apiResponse(message: $exception->getMessage());
        }
    }

    public function updateCartAddress(UpdateCartAddressRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $user_id = auth()->id();
            $data = $request->validated();
            $data['user_id'] = $user_id ;
            $this->cartService->updateCartAddress($data);
            $cart = $this->cartService->getCart($data['temp_user_id']) ;
            return  apiResponse(data:new CartResource($cart) , message: trans('lang.address_set_successfully'));
        }catch (Exception $exception)
        {
            return apiResponse(message: $exception->getMessage());
        }
    }
}
