<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use Spatie\Translatable\HasTranslations;

class Reservation extends Model
{
    use HasFactory, Filterable;

    const PENDING   = 1;
    const CONFIRMED = 2;
    const ATTEND    = 3;
    const COMPLETED = 4;
    const CANCELED  = 5;
    const Expired   = 6;

    protected $fillable  = [
        'customer_id',
        'center_id',
        'check_date',
        'payment_type',
        'payment_status',
        'qr_code',
    ];

    public function history()
    {
        return $this->hasMany(ReservationHistory::class,'reservation_id');
    }

    public function nabadatHistory()
    {
        return $this->hasMany(NabadatHistory::class,'reservation_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'customer_id');
    }

    public function center()
    {
        return $this->belongsTo(Center::class);
    }
}
