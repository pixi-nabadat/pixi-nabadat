<?php

namespace App\Models;

use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use App\Traits\HasAttachment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Center extends Model
{
    use HasTranslations, HasFactory,Filterable, HasAttachment,EscapeUnicodeJson;

    const
        ACTIVE = 1 ,
        NON_ACTIVE = 0 ,
        SUPPORT_AUTO_SERVICE = 1,
        NON_SUPPORT_AUTO_SERVICE = 0;

    protected $fillable = [
        'name', 'phone', 'is_active', 'location_id' ,'lat','lng','is_support_auto_service','address','description',
        'google_map_url','avg_wating_time','featured'
    ];

    protected $casts = [
        'phone' => 'array',
    ];

    protected $table = 'centers';

    public $translatable = ['name','description','address'];


    public function location(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class,'center_id');
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

}
