<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use Spatie\Translatable\HasTranslations;

class Reservation extends Model
{
    use HasFactory, Filterable;


    //todo make one value and make translation for it in translation files
    /*
     * protected static $pending = 'Pending';
     * */
    protected static $pending   = ['en'=>'pending',   'ar'=>'قيد الانتظار'];
    protected static $confirmed = ['en'=>'confirmed', 'ar'=>'تم التأكيد'];
    protected static $attend    = ['en'=>'attend',    'ar'=>'تم الحضور'];
    protected static $completed = ['en'=>'completed', 'ar'=>'مكتمل'];
    protected static $canceled  = ['en'=>'canceled',  'ar'=>'تم الإلغاء'];
    protected static $expired   = ['en'=>'expired',   'ar'=>'تالف'];

    protected $fillable  = [
        'customer_id',
        'center_id',
        'check_date',
        'payment_type',
        'payment_status',
        'qr_code',
    ];

    public static function getStatus(string $status, string $lang){
        return match ($status) {
            'confirm' => self::$confirmed[$lang],
            'attend' => self::$attend[$lang],
            'completed' => self::$completed[$lang],
            'canceled' => self::$canceled[$lang],
            default => self::$pending[$lang],
        };
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
