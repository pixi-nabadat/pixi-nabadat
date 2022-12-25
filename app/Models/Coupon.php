<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    const DISCOUNT_PERCENTAGE = 'percent';
    const DISCOUNT_FLAT = 'flat';
    protected $fillable = ['added_by','code','discount','discount_type','start_date','end_date','min_buy','allowed_usage','coupon_for'];

    protected $dates = [
      'start_date',
      'end_date',
    ];
    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'added_by');
    }
}
