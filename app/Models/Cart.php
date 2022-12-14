<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['discount','sub_total','shipping_cost' ,'address_id', 'net_total','grand_total','user_id','temp_user_id'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    public function itemsWithProduct(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->items()->with('product');
    }

    public function address(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Address::class,'address_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($model) {
            $model->items()->delete();
        });
    }

    public function getDiscountPercentageAttribute(): float|int
    {
        return $this->sub_total !=0 ? (($this->sub_total - $this->grand_total)/$this->sub_total) * 100 : 0 ;
    }
}
