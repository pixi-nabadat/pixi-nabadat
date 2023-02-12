<?php

namespace App\Models;

use App\Enum\ImageTypeEnum;
use App\Traits\Filterable;
use App\Traits\HasAttachment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Slider extends Model
{
    use HasFactory, Filterable, HasAttachment;

    //        'duration',
    protected $fillable = ['order', 'center_id', 'start_date', 'end_date', 'is_active',];


    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }


    public function defaultLogo(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Attachment::class,'attachmentable')->where('type', ImageTypeEnum::LOGO);
    }
}
