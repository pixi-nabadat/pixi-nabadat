<?php

namespace App\Models;

use App\Observers\OrderObserver;
use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use Filterable,EscapeUnicodeJson;

    const
        PENDING     = 1,
        CONFIRMED   = 2,
        SHIPPED     = 3,
        DELIVERED   = 4,
        CANCELED    = 5;

    protected $fillable = ['user_id','payment_status','payment_method','address_info','address_id','shipping_fees','sub_total','grand_total','coupon_id','coupon_discount','points_discount','paymob_transaction_id','relatable_id','relatable_type'];

    protected $casts = [
        'address_info' => 'object'
    ];

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function history(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderHistory::class, 'order_id');
    }

    public function latestStatus(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(OrderHistory::class, 'order_id')->latestOfMany();
    }

    public function scopeActiveOrder(Builder $builder)
    {

        $builder->whereNull(['relatable_id', 'relatable_type']);
    }

    public function getPaymentMethodAttribute($value): array|string|\Illuminate\Contracts\Translation\Translator|\Illuminate\Contracts\Foundation\Application|null
    {
        return trans('lang.'.$value) ;
    }

    // public function getPaymentStatusAttribute($value): array|string|\Illuminate\Contracts\Translation\Translator|\Illuminate\Contracts\Foundation\Application|null
    // {
    //     return trans('lang.'.$value) ;
    // }

    public function getOrderStatusTextAttribute()
    {
        if (!$this->relationLoaded('latestStatus'))
            return null;
        $order_status = $this->latestStatus->status;
        switch ($order_status) {
            case self::PENDING :
                return trans('lang.pending');
            case self::CONFIRMED :
                return trans('lang.confirmed');

            case self::SHIPPED :
                return trans('lang.shipped');

            case self::DELIVERED :
                return trans('lang.delivered');

            case self::CANCELED :
                return trans('lang.canceled');
        }
    }
    protected static function boot()
    {
        parent::boot();
        static::observe(OrderObserver::class);
    }
}
