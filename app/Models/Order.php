<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory,Filterable;
    const PENDING   = 1,
        CONFIRMED   = 2,
        SHIPPED     = 3,
        DELIVERED   = 4,
        CANCELED    = 5;

    const PAYMENTCASH = 1;
    const PAYMENTCREDIT = 0;

    const PAID = 1;
    const UNPAID = 0;

    protected $fillable = ['user_id','payment_status','payment_type','address_info','shipping_fees','sub_total','grand_total','coupon_discount','order_history_id','paymob_transaction_id'];

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function history(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderHistory::class, 'order_id');
    }
}
