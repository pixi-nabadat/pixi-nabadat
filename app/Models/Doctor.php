<?php

namespace App\Models;

use App\Traits\EscapeUnicodeJson;
use App\Traits\Filterable;
use App\Traits\HasAttachment;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Doctor extends Model
{
    use HasTranslations, Filterable, HasAttachment, EscapeUnicodeJson;

    const   ACTIVE = 1,
            NON_ACTIVE = 0;

    const SEARCHFLAG = 5;

    public $translatable = ['name', 'description'];
    protected $fillable = ['name', 'description', 'phone', 'age', 'center_id', 'is_active'];

    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    public function getSearchFlagTextAttribute(): string
    {
        return trans('lang.doctors') ;
    }

    public function getSearchFlagAttribute(): int
    {
        return self::SEARCHFLAG;
    }

    public function defaultLogo()
    {
        return $this->morphOne(Attachment::class,'attachmentable');
    }

    public function getImagePathAttribute()
    {
        $image_path = asset('assets/images/default-image.jpg');
        if ($this->relationLoaded('defaultLogo')&& isset($this->defaultLogo))
        {
           $image_path =  asset($this->defaultLogo->path . "/" . $this->defaultLogo->filename);
        }
        return $image_path ;
    }
}
