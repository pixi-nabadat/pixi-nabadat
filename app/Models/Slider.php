<?php

namespace App\Models;

use App\Enum\ImageTypeEnum;
use App\Traits\Filterable;
use App\Traits\HasAttachment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Slider extends Model
{
    use HasFactory, Filterable, HasAttachment;

    protected $fillable = ['order', 'center_id', 'start_date', 'end_date', 'is_active',];


    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function logo()
    {
        return $this->morphOne(Attachment::class,'attachmentable');
    }
}
