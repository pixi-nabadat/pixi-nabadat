<?php

namespace App\Services;


use App\Exceptions\NotFoundException;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Product;
use Carbon\Carbon;

class CartService extends BaseService
{

    public function addItem($product_id, $quantity, $temp_user_id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        $cart = $this->getCartByUser($temp_user_id);
        $product = Product::find($product_id);
        $cart
            ->items()
            ->updateOrCreate(
                ['product_id' => $product_id],
                ['price' => $product->unit_price, 'quantity' => $quantity]
            );
        return $this->getCart($temp_user_id);
    }

    public function getCartByUser($temp_user_id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        return Cart::query()->firstOrCreate(['temp_user_id' => $temp_user_id]);
    }

    public function getCart($temp_user_id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        $cart = Cart::query()->with(['address', 'items.product', 'coupon','address.city'])->withCount('items')->firstOrCreate(['temp_user_id' => $temp_user_id]);
        $this->refresh($cart);
        return $cart;
    }

    /**
     * @param Cart $cart
     * @return void
     */
    private function refresh(Cart $cart): void
    {
        $items = $cart->itemsWithProduct()->get();
        if ($items->isEmpty()) {
            $cart->delete();
            return;
        }

        $grand_total = $items->sum(function ($item) {
            return $item->quantity * ($item->product->unit_price - ($item->product->unit_price * $item->product->product_discount / 100));
        });

        $sub_total = $items->sum(function ($item) {
            return $item->quantity * $item->product->unit_price;
        });

        $cart->update([
            "sub_total" => $sub_total,
            "net_total" => $grand_total,
            "grand_total" => $grand_total,
        ]);
    }

    public function removeItem(int $item_id, $temp_user_id)
    {
        $cart = $this->getCart($temp_user_id);
        if ($cart) {
            $cartItem = $cart->items()->find($item_id);
            if ($cartItem) {
                $cartItem->delete();
                $this->refresh($cart);
            }
        }
        return $cart->refresh();
    }

    public function emptyCart($temp_user_id)
    {
        $cart = $this->getCartByUser($temp_user_id);
        return $cart ? $cart->delete() : false;
    }

    /**
     * @throws NotFoundException
     */
    public function applyCouponOnCart(array $data = []): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|bool
    {
        $coupon = Coupon::where('code', $data['coupon_code'])->first();
        if (!$coupon)
            throw new NotFoundException(trans('lang.coupon_not_available'));
        $coupon_usage =CouponUsage::where('user_id',$data['user_id'])->where('coupon_id',$coupon->id)->first();
        //check if coupon code exists and is valid
        if (
            !(
                Carbon::parse($coupon->start_date)->gte(Carbon::now()->format('y-m-d')) &&
                Carbon::now()->lte(Carbon::parse($coupon->end_date)->format('y-m-d')) &&
                $coupon->coupon_for == Coupon::STORECOUPON
            )
        )
            throw new NotFoundException(trans('lang.coupon_not_available'));

        if ( $coupon->allowed_usage <= optional($coupon_usage)->number_of_usage)
            throw new NotFoundException(trans('lang.you_used_this_coupon_before'));

        $cart = $this->getCartByUser($data['temp_user_id']);
        if ($cart->grand_total < $coupon->min_buy)
            throw new NotFoundException(trans('lang.you_should_exceed_minimum_limitation_to_use_coupon : ') . $coupon->min_buy);
        $cart->coupon_id = $coupon->id;
        $cart->user_id = $data['user_id'];
        $cart->save();
        $cart->refresh();
        return true;
    }

    /**
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws NotFoundException
     */
    public function updateCartAddress(array $data =[]): bool
    {
        $cart = $this->getCartByUser($data['temp_user_id']);
        $address = app()->make(AddressService::class)->find($data['address_id'],['city']);
        if (!$address)
            throw new NotFoundException(trans('lang.address_not_found'));
        $cart->address_id = $address->id;
        $cart->user_id = $data['user_id'];
        $cart->shipping_cost = $address->city->shipping_cost;
        $cart->save();
        return true ;
    }

}
