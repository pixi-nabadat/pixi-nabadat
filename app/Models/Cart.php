<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['discount','sub_total','shipping_cost' , 'net_total','grand_total','tax','user_id','address_id', 'temp_user_id'];
    
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(Product::class, 'cart_items', 'cart_id', 'product_id');
    }

    public static function refreshCart(Cart $cart, float $tax = 0.0, float $shipping_cost = 0.0): bool
    {
        $subtotal = 0;
        foreach($cart->items as $item){
            $subtotal += $item->pivot->value('quantity') * $item->pivot->value('price');
        }
        $cart->update([
            'discount'      => '0',
            'tax'           => $tax,
            'shipping_cost' => $shipping_cost,
        ]);
        $cart->refresh();
        $cart->update([
            'sub_total'     => $subtotal,
            'grand_total'   => $cart->value('tax') + $cart->value('shipping_cost'),
        ]);
        $cart->refresh();

        $cart->update([
            'net_total' => $cart->value('sub_total') + $cart->value('grand_total') - $cart->value('discount'),
        ]);
        return true;
    }
}
