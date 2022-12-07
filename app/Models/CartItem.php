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

    public function getPriceAfterDiscountAttribute()
    {
       if (!$this->relationLoaded('product'))
           return null ;
        $currentDate  = Carbon::now();
        $discountEndDate   = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($this->product->discount_end_date));
        $discountStartDate = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($this->product->discount_start_date));

        if($currentDate->gte($discountStartDate) && $currentDate->lt($discountEndDate))
            return $this->product->unit_price - $this->product->discount;
        return $this->product->unit_price;
    }
}
