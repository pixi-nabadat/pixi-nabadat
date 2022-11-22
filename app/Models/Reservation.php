<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
         'center_id',
         'confirm_date',
         'check_date',
         'payment_type',
         'payment_status',
         'qr_code',
    ];
    
}
