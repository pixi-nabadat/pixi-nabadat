<?php

namespace App\Models;

use App\Observers\ReservationHistoryObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationHistory extends Model
{
    use HasFactory;

    protected $table = "reservation_history";

    protected $fillable = [
        'reservation_id',
        'status',
        'cancel_reason_id',
        'comment',
        'added_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function added_by()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function getStatusAttribute($value): array|string|\Illuminate\Contracts\Translation\Translator|\Illuminate\Contracts\Foundation\Application|null
    {
        return match ($value) {
            Reservation::CONFIRMED => trans('lang.confirmed'),
            Reservation::APPROVED => trans('lang.approved'),
            Reservation::ATTEND => trans('lang.attend'),
            Reservation::COMPLETED => trans('lang.completed'),
            Reservation::CANCELED => trans('lang.canceled'),
            Reservation::Expired => trans('lang.expired'),
            default => trans('lang.pending'),
        };
    }

    public function completeReservation()
    {
        if($this->getAttributes()['status'] == Reservation::COMPLETED){
            $reservation = $this->reservation;
            $reservationPulses   = $reservation->nabadatHistory->sum('num_nabadat');
            $user = $reservation->user;
            $user->updateWallet(reservationPulses: $reservationPulses);    
        }
    }
    protected static function boot()
    {
        parent::boot();
        static::observe(ReservationHistoryObserver::class);
    }
}
