<?php

namespace App\Services;


use App\Models\Cart;
use App\Models\Product;

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

        $cart->update([
            "sub_total" => $sub_total,
            "net_total" => $grand_total,
            "grand_total" => $grand_total,
        ]);
    }

}
