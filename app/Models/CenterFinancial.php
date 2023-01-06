<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CenterFinancial extends Model
{
    use HasFactory;

    protected $fillable = [
        'center_id','app_discount','cash_wallet','credit_wallet','cleared_cash_amount','cleared_credit_amount','cash_clearing','credit_clearing',
    ];

    public function center():BelongsTo
    {
        return $this->belongsTo(Center::class, 'center_id');
    }
}
