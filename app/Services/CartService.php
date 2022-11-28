<?php

namespace App\Services;


use App\Models\Cart;

class CartService extends BaseService
{

    public function store(array $data = [], array $with =[])
    {
        $cart = Cart::create($data);
        $cart = Cart::with($with)->find($cart->id);
        if (!$cart)
            return false ;

        return $cart;
    } //end of store
    
}
