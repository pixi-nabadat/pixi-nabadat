<?php

namespace App\Models;

use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use App\Traits\HasAttachment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Translatable\HasTranslations;
use Laravel\Sanctum\HasApiTokens;


class Center extends Authenticatable
{
    use HasTranslations, HasApiTokens,HasFactory,Filterable, HasAttachment,EscapeUnicodeJson,Notifiable;

    const
        ACTIVE = 1 ,
        NON_ACTIVE = 0 ,
        SUPPORT_AUTO_SERVICE = 1,
        NON_SUPPORT_AUTO_SERVICE = 0;

    const CASH = 'cash';
    const CREDIT = 'credit';

    const SEARCHFLAG = 2 ;

    protected $fillable = [
        'name','email', 'phone','other_phones','user_name','password', 'is_active', 'location_id' ,'lat','lng','is_support_auto_service','address','description',
        'google_map_url','avg_waiting_time','featured', 'rate', 'support_payments','app_discount',
    ];

    protected $casts = [
        'other_phones' => 'array',
        'support_payments' => 'array',
    ];
    protected $hidden = [
        'password',
    ];

    protected $table = 'centers';
    protected $guarded = 'center' ;

    public $translatable = ['name','description','address'];

    public function getToken(): string
    {
        return $this->createToken(config('app.name')."_center",['center'])->plainTextToken;
    }

    public function location(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function doctors(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Doctor::class,'center_id');
    }

    public function device()
    {
        return $this->hasMany(Device::class,'center_id');
    }

    public function appointments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Appointment::class,'center_id');
    }

    public function rates(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Rate::class, 'ratable');
    }
    public function devices()
    {
        return $this->belongsToMany(Device::class, 'center_devices', 'center_id', 'device_id')
            ->withPivot(['id', 'regular_price', 'nabadat_app_price','auto_service_price','number_of_devices'])->withTimestamps();
    }

    public function centerFinancial(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CenterFinancial::class, 'center_id');
    }
    /**
     * @param Center $center
     * @param float $amount
     * @param string $amountType
     */
    public static function setPoints(Center $center, float $amount, string $amountType): bool
    {

        $pointsPerPound = config('global.center_points_per_pound') !== null ? config('global.center_points_per_pound') : Setting::get('points', 'center_points_per_pound');
        $pointsExpireDaysCount = config('global.center_points_expire_days_count') !== null ? config('global.center_points_expire_days_count') : Setting::get('points', 'center_points_expire_days_count');
        if ($amountType == 'points')
            $center->points += $amount;
        else
            $center->points += $pointsPerPound * $amount;
        $center->points_expire_date = Carbon::now()->addDays($pointsExpireDaysCount);
        $center->save();
        return true;
    }

    public function getSearchFlagTextAttribute(): string
    {
        return trans('lang.centers') ;
    }
    public function getSearchFlagAttribute(): int
    {
        return self::SEARCHFLAG;
    }
}
