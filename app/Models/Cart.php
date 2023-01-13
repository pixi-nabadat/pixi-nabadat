<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['coupon_id', 'sub_total', 'shipping_cost', 'address_id', 'net_total', 'grand_total', 'user_id', 'temp_user_id'];

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

    public function getGrandTotalAfterDiscountAttribute()
    {
        $coupon_usage_count = 0 ;
        $user = auth('sanctum')->check() ? auth()->user() : null ;
        if ($user){
            $coupon_usage = $user->coupons()->where('coupon_id',$this->coupon->id)->first();
            $coupon_usage_count = $coupon_usage->number_of_usage ?? 0 ;
        }
        $value = $this->grand_total;
        if (!$this->relationLoaded('coupon'))
            return $value;
        if (
            Carbon::now(config('app.africa_timezone'))->gte(optional($this->coupon)->start_date) &&
            Carbon::now(config('app.africa_timezone'))->lte(optional($this->coupon)->end_date) &&
            optional($this->coupon)->coupon_for == Coupon::STORECOUPON && optional($this->coupon)->min_buy < $value &&
            $this->coupon->allowed_usage >= $coupon_usage_count
        ) {
            if (optional($this->coupon)->discount_type == Coupon::DISCOUNT_PERCENTAGE)
                $value = $value - ($value * (optional($this->coupon)->discount / 100));
            if (optional($this->coupon)->discount_type == Coupon::DISCOUNT_FLAT)
                $value = $value - optional($this->coupon)->discount;
        }
        return $value;

    }

    public function getDiscountAttribute(): int
    {
        $discount = 0;
        if (!$this->relationLoaded('coupon'))
            return $discount;
        $checkIfCouponValied = $this->checkIfCouponAvaliable();
        if ($checkIfCouponValied)
            $discount = $this->coupon->discount;
        return $discount;

    }

    private function checkIfCouponAvaliable()
    {
        if (
            Carbon::now(config('app.africa_timezone'))->gte(optional($this->coupon)->start_date)
            && Carbon::now(config('app.africa_timezone'))->lte(optional($this->coupon)->end_date)
            && optional($this->coupon)->coupon_for == Coupon::STORECOUPON
            && optional($this->coupon)->min_buy < $this->grand_total)
            return true;
        else
            return false;
    }

    public function getSavedAmountAttribute(): float|int
    {
        return $this->sub_total  - ($this->grand_total_after_discount + $this->shipping_cost);
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
