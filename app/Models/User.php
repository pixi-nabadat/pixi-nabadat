<?php

namespace App\Models;

use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Translatable\HasTranslations;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Filterable, HasTranslations, EscapeUnicodeJson;

    const SUPERADMINTYPE = 1;
    const CUSTOMERTYPE = 2;
    const CENTERADMIN = 4;

    const ACTIVE = 1;
    const NONACTIVE = 0;

    public $translatable = ['name', 'description'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'type', 'description', 'user_name',
        'last_login', 'date_of_birth', 'is_active', 'location_id', 'points', 'points_expire_date'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @param User $user
     * @param float $amount
     * @param string $amountType
     */
    public static function setPoints(User $user, float $amount, string $amountType): bool
    {

        $pointsPerPound = config('global.patient_points_per_pound') !== null ? config('global.patient_points_per_pound') : Setting::get('points', 'patient_points_per_pound');
        $pointsExpireDaysCount = config('global.patient_points_expire_days_count') !== null ? config('global.patient_points_expire_days_count') : Setting::get('points', 'patient_points_expire_days_count');
        if ($amountType == 'points')
            $user->points += $amount;
        else
            $user->points += $pointsPerPound * $amount;
        $user->points_expire_date = Carbon::now()->addDays($pointsExpireDaysCount);
        $user->save();
        return true;
    }

    /**
     * Get the user's first name.
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->createToken(config('app.name'))->plainTextToken;
    }

    public function getId()
    {
        return $this->id;
    }

    public function location(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function center(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(Center::class, CenterDoctor::class, 'doctor_id', 'center_id');
    }

    public function cart(): \Illuminate\Database\Eloquent\Relations\hasOne
    {
        return $this->hasOne(Cart::class);
    }

    public function coupons(): \Illuminate\Database\Eloquent\Relations\belongsToMany
    {
        return $this->belongsToMany(Coupon::class, 'coupon_usages', 'user_id', 'coupon_id');
    }

    public function defaultAddress(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->addresses()->where('is_default', true);
    }

    public function addresses(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    public function orders(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function nabadatWallet(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(NabadatWallet::class, 'user_id');
    }

    public function package(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserPackage::class, 'user_id');
    }

    public function fcmToken(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(UserDeviceTokens::class,'user_id');
    }
}
