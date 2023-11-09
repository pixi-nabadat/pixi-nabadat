<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory,Filterable;

    public const PENDING = 1;
    public const COMEPELETED = 2;

    protected $fillable = [
        'center_id',
        'total_center_dues',
        'total_nabadat_dues',
        'status',
        'completed_date',
        'center_cash_dues',
        'nabadat_cash_dues',
        'center_credit_dues',
        'nabadat_credit_dues'
    ];
    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class, 'center_id');
    }

    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Transaction::class, 'invoice_id');
    }

    public function getStatusTextAttribute()
    {
        return $this->status == self::PENDING ? trans('lang.invoice_pending') : trans('lang.invoice_completed');
    }
}
