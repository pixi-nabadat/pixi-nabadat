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
        'user_id',
        'reservation_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::observe(ReservationHistoryObserver::class);
    }
}
