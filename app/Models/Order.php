<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    const PENDING = 'pending',
          DELIVERED = 'delivered',
          CONFIRMED = 'confirmed',
          CANCELED = 'canceled',
          SHIPPED = 'shipped';

    const PAYMENTCASH = 'cash';
    const PAYMENTCREDIT = 'credit';


    protected $fillable = ['payment_status','payment_type','shipping_address','shipping_fees','sub_total','grand_total','coupon_discount','order_history_id'];

    public function orderItem(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function history(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(OrderHistory::class, 'order_id');
    }
}
