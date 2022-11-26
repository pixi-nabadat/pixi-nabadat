<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use Spatie\Translatable\HasTranslations;

class Reservation extends Model
{
    use HasFactory, Filterable, HasTranslations;
    

    protected static $pending   = ['en'=>'pending',   'ar'=>'قيد الانتظار'];
    protected static $confirmed = ['en'=>'confirmed', 'ar'=>'تم التأكيد'];
    protected static $attend    = ['en'=>'attend',    'ar'=>'تم الحضور'];
    protected static $completed = ['en'=>'completed', 'ar'=>'مكتمل'];
    protected static $canceled  = ['en'=>'canceled',  'ar'=>'تم الإلغاء'];
    protected static $expired   = ['en'=>'expired',   'ar'=>'تالف'];

    protected $fillable  = [
        'customer_id',
        'center_id',
        'confirm_date',
        'check_date',
        'payment_type',
        'payment_status',
        'qr_code',
    ];

    public static function pending(string $lang){
        return Reservation::$pending[$lang];
    }
    public static function confirm(string $lang){
        return Reservation::$confirmed[$lang];
    }
    public static function attend(string $lang){
        return Reservation::$attend[$lang];
    }
    public static function completed(string $lang){
        return Reservation::$completed[$lang];
    }
    public static function expired(string $lang){
        return Reservation::$expired[$lang];
    }
    public static function canceled(string $lang){
        return Reservation::$canceled[$lang];
    }

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
