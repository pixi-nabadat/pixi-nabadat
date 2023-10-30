<?php

namespace App\Models;

use App\Enum\CenterStatusEnum;
use App\Enum\ImageTypeEnum;
use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use App\Traits\HasAttachment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Center extends Model
{
    use HasTranslations, HasFactory,Filterable, HasAttachment,EscapeUnicodeJson;

    const
        ACTIVE = 1 ,
        NON_ACTIVE = 0 ,
        SUPPORT_AUTO_SERVICE = 1,
        NON_SUPPORT_AUTO_SERVICE = 0;

    const CASH = 'cash';
    const CREDIT = 'credit';

    const SEARCHFLAG = 2 ;

    protected $fillable = [
        'lat','lng','is_support_auto_service','address','description','phones','name',
        'google_map_url','avg_waiting_time','featured', 'rate', 'support_payments','pulse_price','pulse_discount','app_discount', 'status',
    ];

    protected $casts = [
        'phones' => 'array',
        'support_payments' => 'array',
    ];

    protected $table = 'centers';

    public $translatable = ['description','address','name'];

    public function sliders(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Slider::class, 'sliderable');
    }

    public function location(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class,'center_id');
    }

    public function doctors(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Doctor::class,'center_id');
    }

    public function appointments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Appointment::class,'center_id');
    }

    public function rates(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Rate::class, 'ratable');
    }

    public function defaultLogo(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Attachment::class,'attachmentable')->where('type', ImageTypeEnum::LOGO);
    }
    public function devices(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Device::class, 'center_devices')
            ->withPivot(['id','auto_service','is_active','number_of_devices'])->withTimestamps();
    }

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class,'center_id');
    }

    public function userPackages(): HasMany
    {
        return $this->hasMany(Package::class,'center_id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class,'center_id');
    }

    /**
     * @param Center $center
     * @param float $amount
     * @param string $amountType
     */

    public function getSearchFlagTextAttribute(): string
    {
        return trans('lang.centers') ;
    }

    public function getImagePathAttribute(): string
    {
        return $this->relationLoaded('defaultLogo') && isset($this->defaultLogo) ? asset($this->defaultLogo->path."/".$this->defaultLogo->filename) : asset('assets/images/default-image.jpg');
    }

    public function getImageIdAttribute()
    {
        return $this->relationLoaded('defaultLogo') && isset($this->defaultLogo) ? $this->defaultLogo->id : null;
    }

    public function getSearchFlagAttribute(): int
    {
        return self::SEARCHFLAG;
    }

    public function getPulsePriceAfterDiscountAttribute(): float
    {
        return  round($this->pulse_price - ($this->pulse_price * ($this->pulse_discount/100)), 3);
    }


    public function scopeActive(Builder $builder): Builder
    {
        return $builder->whereHas('user',fn($query)=>$query->where('is_active',User::ACTIVE))
            ->whereNotNull('pulse_price')->whereNotNull('pulse_discount')->whereNotNull('app_discount');
    }

    public function getCenterStatusAttribute(){
        switch($this->status){
            case CenterStatusEnum::APPROVED:
                return trans('lang.approved');
                break;
            case CenterStatusEnum::REJECTED:
                return trans('lang.rejected');
                break;
            case CenterStatusEnum::UNDER_REVIEWING:
                return trans('lang.under_reviewing');
                break;
            default:
                return "-";
        }
    }
}
