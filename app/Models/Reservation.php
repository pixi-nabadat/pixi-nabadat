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
    const APPROVED = 2;
    const CONFIRMED = 3;
    const ATTEND = 4;
    const COMPLETED = 5;
    const CANCELED = 6;
    const Expired = 7;

    protected $fillable = [
        'customer_id', 'center_id', 'check_date', 'period', 'payment_type', 'payment_status', 'qr_code',
    ];

    public static function getStatusText(int $status): array|string|\Illuminate\Contracts\Translation\Translator|\Illuminate\Contracts\Foundation\Application|null
    {

        return match ($status) {
            Reservation::PENDING => trans('lang.pending'),
            Reservation::APPROVED => trans('lang.approved'),
            Reservation::CONFIRMED => trans('lang.confirmed'),
            Reservation::ATTEND => trans('lang.attend'),
            Reservation::COMPLETED => trans('lang.completed'),
            Reservation::CANCELED => trans('lang.canceled'),
            Reservation::Expired => trans('lang.expired'),
            default => trans('lang.pending'),
        };
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

    public function getReservationStatusTextAttribute(): array|string|\Illuminate\Contracts\Translation\Translator|\Illuminate\Contracts\Foundation\Application|null
    {
        if (!$this->relationLoaded('latestStatus'))
            return null;
        $order_status = $this->latestStatus->status;
        return match ($order_status) {
            Reservation::PENDING => trans('lang.pending'),
            Reservation::APPROVED => trans('lang.approved'),
            Reservation::CONFIRMED => trans('lang.confirmed'),
            Reservation::ATTEND => trans('lang.attend'),
            Reservation::COMPLETED => trans('lang.completed'),
            Reservation::CANCELED => trans('lang.canceled'),
            Reservation::Expired => trans('lang.expired'),
            default => trans('lang.pending'),
        };
    }
}