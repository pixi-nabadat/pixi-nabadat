<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CartItemService extends BaseService
{

    public function store(array $data = [], array $with =[])
    {
        if(Auth::check())
        {
            $cart = Auth::user()->cart->first();//you show create cart while creating the user
        }else{
            $cart = Cart::firstOrCreate([
                'temp_user_id' => $data['serial']
            ]);
        }
        
        $product           = Product::find($data['product_id']);
        $currentDate       = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::today());
        $discountEndDate   = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($product->discount_end_date));
        $discountStartDate = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($product->discount_start_date));

        if($currentDate->gte($discountStartDate) && $currentDate->lt($discountEndDate))
            $price = $product->unit_price - $product->discount;
        else
            $price = $product->unit_price;
        
        $cart->items()->attach(
            $data['product_id'],
            [
                'quantity' => $data['quantity'],
                'price'    => $price
            ]
        );

        $refreshStatus = Cart::refreshCart($cart,2,4);
        if($refreshStatus)
            return $cart->with($with)->get();

    } //end of store
    
    public function destroy($id)
    {
        $cartItem = CartItem::find($id);
        if ($cartItem != null) {
            $cartItem->delete();
            return true;
        }else{
            return false;
        }
    } //end of delete
}
