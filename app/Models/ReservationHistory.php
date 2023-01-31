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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function getStatusAttribute($value)
    {
        switch($value){
            case 1:
                return trans('lang.pending');
                break;
            case 2:
                return trans('lang.confirmed');
                break;
            case 3:
                return trans('lang.attend');
                break;
            case 4:
                return trans('lang.completed');
                break;
            case 5:
                return trans('lang.canceled');
                break;
            case 6:
                return trans('lang.expired');
                break;
            default:
                return $value;
        }
    }
    protected static function boot()
    {
        parent::boot();
        static::observe(ReservationHistoryObserver::class);
    }
}
