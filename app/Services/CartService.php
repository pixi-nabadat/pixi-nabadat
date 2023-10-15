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
                ['price' => $product->unit_price - $product->discount, 'quantity' => $quantity]
            );
        return $this->getCart($temp_user_id);
    }

    public function getCartByUser($temp_user_id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        return Cart::query()->firstOrCreate(['temp_user_id' => $temp_user_id]);
    }

    public function getCart($temp_user_id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        $cart = Cart::query()->with(['user:id,points','address', 'items.product.defaultLogo', 'coupon','address.city'])->withCount('items')->firstOrCreate(['temp_user_id' => $temp_user_id]);
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

        $grand_total = $items->sum(function ($item) use($cart){
            $grandTotalBeforeDiscount = $item->quantity * ($item->product->unit_price - ($item->product->unit_price * $item->product->discount / 100));
            $couponDiscount = $grandTotalBeforeDiscount * ($cart->coupon_discount/100);
            return $grandTotalBeforeDiscount - $couponDiscount + $cart->shipping_cost;
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

    public function removeItem(int $item_id, string $temp_user_id): \Illuminate\Database\Eloquent\Model
    {
        $cart = $this->getCartByUser($temp_user_id);
        if ($cart) {
            $cartItem = $cart->items()->find($item_id);
            $cartItem?->delete();
            $this->refresh($cart);
        }
        return $this->getCart($temp_user_id);
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
        $coupon_usage =CouponUsage::where('temp_user_id',$data['temp_user_id'])->where('coupon_id',$coupon->id)->first();
        //check if coupon code exists and is valid
        if (
            !(
                Carbon::now(config('app.africa_timezone'))->gte($coupon->start_date) &&
                Carbon::now(config('app.africa_timezone'))->lte($coupon->end_date) &&
                $coupon->coupon_for == Coupon::STORECOUPON
            )
        )
            throw new NotFoundException(trans('lang.coupon_not_available'));

        if ( $coupon->allowed_usage <= optional($coupon_usage)->number_of_usage)
            throw new NotFoundException(trans('lang.you_exceed_allowed_usage_for_this_coupon'));

        $cart = $this->getCartByUser($data['temp_user_id']);
        if ($cart->grand_total < $coupon->min_buy)
            throw new NotFoundException(trans('lang.you_should_exceed_minimum_limitation_to_use_coupon : ') . $coupon->min_buy);
        $cart->coupon_id = $coupon->id;
        $cart->coupon_discount = $coupon->discount;
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
        if (!$cart)
            throw new NotFoundException(trans('lang.cart_not_found'));
        $address = app()->make(AddressService::class)->find($data['address_id'],['city']);
        if (!$address)
            throw new NotFoundException(trans('lang.address_not_found'));
        $cart_data = [
            'address_id'=>$address->id,
            'user_id'=>$data['user_id'],
            'shipping_cost'=> $address->city->shipping_cost,
        ];
        $cart->update($cart_data);
        return true ;
    }

}
