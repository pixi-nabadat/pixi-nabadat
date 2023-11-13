<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory,Filterable;
    const STORECOUPON = 'store';
    const RESERVATIONCOUPON = 'reservation';
    protected $fillable = ['added_by','code','discount','start_date','end_date','min_buy','allowed_usage','coupon_for', 'is_active'];

    public function creator(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'added_by');
    }
}
