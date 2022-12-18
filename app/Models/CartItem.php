<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id','product_id','quantity','price'] ;

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    /**
     * @return float|int|mixed
     */
    public function getPriceAfterDiscountAttribute()
    {
        return $this->relationLoaded('product')
            ? getPriceAfterDiscount($this->product->unit_price,$this->product->product_discount)
            : $this->price;
    }
}
