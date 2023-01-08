<?php

namespace App\Services;


use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use Carbon\Carbon;

class CartService extends BaseService
{

    public function getCart($temp_user_id)
    {
        $cart = Cart::query()->with(['address','items.product'])->withCount('items')->firstOrCreate(['temp_user_id' => $temp_user_id]);
        $this->refresh($cart);
        return $cart;
    }


    public function getCartByUser($temp_user_id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        return Cart::query()->firstOrCreate(['temp_user_id' => $temp_user_id]);
    }


    public function addItem($product_id,$quantity,$temp_user_id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        $cart = $this->getCartByUser($temp_user_id);
        $product = Product::find($product_id);
        $cart
            ->items()
            ->updateOrCreate(
                ['product_id' => $product_id],
                ['price'      =>$product->unit_price, 'quantity' =>$quantity]
            );
        return $this->getCart($temp_user_id) ;
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
            return $item->quantity * ($item->product->unit_price - ($item->product->unit_price * $item->product->product_discount/100));
        });

        $sub_total = $items->sum(function ($item) {
            return $item->quantity * $item->product->unit_price;
        });

        $grand_total = $grand_total - ($grand_total*($cart->coupon_discount/100)) + $cart->shipping_cost;
        $cart->update([
            "sub_total" => $sub_total,
            "net_total" => $grand_total,
            "grand_total" => $grand_total,
        ]);
    }

    public function updateCartCouponData(array $data = []){
        $cart = $this->getCartByUser($data['temp_user_id']);
        $coupon = Coupon::where('code',$data['coupon_code'])->where->first();
        //check if coupon code exsists and is valied
        $coupon_is_valid = false;
        if (Carbon::parse($coupon->start_date)->gte(Carbon::now()->format('y-m-d')) && Carbon::parse($coupon->end_date)->lte(Carbon::now()->format('y-m-d')))
            $coupon_is_valid = true ;
        if (!$coupon_is_valid)
            return false ;
        $cart->coupon_code = $coupon->code ;
        $cart->coupon_discount = $coupon->discount;
        $cart->save();
        $cart->refresh();
        return $this->getCart($data['temp_user_id']);
    }

}
