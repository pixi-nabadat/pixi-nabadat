<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;


class UserPackage extends Model
{
    use HasFactory,Filterable;

    protected $fillable = [
        'num_nabadat',
        'price',
        'center_id',
        'user_id',
        'package_id',
        'discount_percentage',
        'payment_method',
        'payment_status',
        'usage_status',
        'used',
        'remaining',
    ];
}
