<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['coupon_id', 'coupon_discount', 'sub_total', 'shipping_cost', 'address_id', 'net_total', 'grand_total', 'user_id', 'temp_user_id'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function coupon(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function itemsWithProduct(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->items()->with('product');
    }

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    public function address(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function getSavedAmountAttribute(): float|int
    {
        return $this->sub_total - ($this->grand_total - $this->shipping_cost);
    }

    public function getPoundsForPointsAttribute(): float|int
    {
        return $this->relationLoaded('user') && isset($this->user) ? changePointsToPounds($this->user->points) : 0;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getShippingCostAttribute($value)
    {
        if (!$this->relationLoaded('address'))
            return $value ;
        return isset($this->address->city) ? $this->address->city->shipping_cost : $value;
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($model) {
            $model->items()->delete();
        });
    }
}
