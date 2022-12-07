<?php

namespace App\Services;


use App\Models\Cart;
use App\Models\Product;

class CartService extends BaseService
{

    public function getCart($user, $tem_user_id = null): \Illuminate\Database\Eloquent\Builder
    {
        $cart = Cart::query()->with('items.product')->withCount('items');
        if (is_null($user))
            $cart->firstOrCreate(['tem_user_id' => $tem_user_id]);
        else
            $cart->firstOrCreate(['user_id' => $user->id]);
        $this->refresh($cart);
        return $cart;
    }


    public function getCartByUser($user, $tem_user_id = null): \Illuminate\Database\Eloquent\Builder
    {
        $cart = Cart::query() ;
        if (is_null($user))
            $cart->firstOrCreate(['tem_user_id' => $tem_user_id], ['user_id' => null]);
        else
            $cart->firstOrCreate(['user_id' => $user->id]);
        return $cart;
    }


    public function addItem($product_id,$quantity,$user,$temp_user_id=null): \Illuminate\Database\Eloquent\Builder
    {
        $cart = $this->getCartByUser($user,$temp_user_id);
        $product = Product::find($product_id);
        $cart
            ->items()
            ->updateOrCreate(
                ['product_id' => $product_id]
                ,
                [
                    'price'    =>$product->price,
                    'quantity' =>$quantity,
                ]
            );
        return $this->getCart($user,$temp_user_id) ;
    }

    public function removeItem(int $item_id, $user, $tem_user_id)
    {
        $cart = $this->getCart($user, $tem_user_id);
        if ($cart) {
            $cartItem = $cart->items()->where('id', $item_id)->first();
            if ($cartItem) {
                $cartItem->delete();
                $this->refresh($cart);
            }
        }
        return $cart->refresh();
    }


    public function emptyCart($user, $temp_user_id = null)
    {
        $cart = $this->getCart($user, $temp_user_id);
        return $cart ? $cart->delete() : false;
    }

    /**
     * @param Cart $cart
     * @return void
     */
    private function refresh(Cart $cart): void
    {

        $items = $cart->items()->get();
        if ($items->isEmpty()) {
            $cart->delete();
            return;
        }
        $grand_total = $items->sum(function ($item) {
            return $item->quantity * $item->price;
        });

        $sub_total = $items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
        $cart->update([
            "sub_total" => $sub_total,
            "net_total" => $grand_total,
            "grand_total" => $grand_total,
        ]);
    }

}
