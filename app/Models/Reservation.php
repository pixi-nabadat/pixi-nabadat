<?php

namespace App\Models;

use App\Enum\PaymentStatusEnum;
use App\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    use HasFactory, Filterable;

    const PENDING = 1;
    const CONFIRMED = 2;
    const ATTEND = 3;
    const COMPLETED = 4;
    const CANCELED = 5;
    const Expired = 6;

    protected $fillable = [
        'customer_id',
        'center_id',
        'check_date',
        'from',
        'to',
        'payment_type',
        'payment_status',
        'qr_code',
    ];

    public static function getStatusText(int $status)
    {
        switch ($status){
            case self::PENDING:
                return trans('lang.pending');
            case self::CONFIRMED:
                return trans('lang.confirmed');
            case self::ATTEND:
                return trans('lang.attend');
            case self::COMPLETED:
                return trans('lang.completed');
            case self::CANCELED:
                return trans('lang.canceled');
            case self::Expired:
                return trans('lang.expired');
        }
    }

    public function history(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ReservationHistory::class, 'reservation_id');
    }

    public function latestStatus(): HasOne
    {
        return $this->hasOne(ReservationHistory::class, 'reservation_id')->latestOfMany();
    }

    public function nabadatHistory(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(NabadatHistory::class, 'reservation_id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function center(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function getReservationStatusTextAttribute()
    {
        if (!$this->relationLoaded('latestStatus'))
            return null;
        $order_status = $this->latestStatus->status;
        switch ($order_status) {
            case self::PENDING :
                return trans('lang.pending');
            case self::CONFIRMED :
                return trans('lang.confirmed');
            case self::ATTEND :
                return trans('lang.shipped');
            case self::COMPLETED :
                return trans('lang.completed');
            case self::CANCELED :
                return trans('lang.canceled');
        }
    }

    public function getFromAttribute($value)
    {
        return Carbon::createFromTimeString($value)->format('g:i a');
    }

    public function getToAttribute($value)
    {
        return Carbon::createFromTimeString($value)->format('g:i a');
    }
}