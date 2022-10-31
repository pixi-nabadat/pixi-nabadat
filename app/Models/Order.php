<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['payment_status','payment_type','shipping_address','shipping_fees','sub_total','grand_total','coupon_discount'];
}
