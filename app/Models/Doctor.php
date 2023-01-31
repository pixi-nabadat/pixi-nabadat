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
    public $translatable = ['name', 'description'];
    protected $fillable = ['name', 'description', 'phone', 'center_id', 'age', 'is_active'];

    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    public function defaultLogo()
    {
        return $this->morphOne(Attachment::class,'attachmentable');
    }
}
