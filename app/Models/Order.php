<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, Filterable;
    use SoftDeletes;

    const PENDING = 1,
        CONFIRMED = 2,
        SHIPPED = 3,
        DELIVERED = 4,
        CANCELED = 5;

    const PAYMENTCASH = 1;
    const PAYMENTCREDIT = 0;

    const PAID = 1;
    const UNPAID = 0;

    protected $fillable = ['user_id', 'payment_status', 'payment_type', 'address_info', 'address_id', 'shipping_fees', 'sub_total', 'grand_total', 'coupon_discount', 'order_history_id', 'paymob_transaction_id', 'relatable_id', 'relatable_type', 'deleted_at'];

    protected $casts = [
        'address_info' => 'object'
    ];

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function history(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderHistory::class, 'order_id');
    }

    public function orderStatus(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(OrderHistory::class);
    }

    public function scopeActiveOrder(Builder $builder)
    {

        $builder->whereNull(['relatable_id', 'relatable_type']);
    }

    public function getPaymentStatusAttribute($value)
    {
        switch ($value) {
            case self::PAID :
                return trans('lang.paid');
            case self::UNPAID :
                return trans('lang.unpaid');
        }
    }

    public function getOrderStatusTextAttribute()
    {
        if (!$this->relationLoaded('orderStatus'))
            return null;
        $order_status = $this->orderStatus->status;
        switch ($order_status) {
            case self::PENDING :
                return trans('lang.pending');
            case self::CONFIRMED :
                return trans('lang.confirmed');

            case self::SHIPPED :
                return trans('lang.shipped');

            case self::DELIVERED :
                return trans('lang.deliverd');

            case self::CANCELED :
                return trans('lang.canceled');
        }
    }
}
