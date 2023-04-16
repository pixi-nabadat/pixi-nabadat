<?php

namespace App\Models;

use App\Observers\SliderObserver;
use App\Traits\Filterable;
use App\Traits\HasAttachment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Slider extends Model
{
    use HasFactory, Filterable, HasAttachment;

    protected $fillable = ['order', 'center_id', 'start_date', 'end_date', 'is_active',];


    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function attachments(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachmentable');
    }

    public function getImagePathAttribute(): string
    {
        return $this->relationLoaded('attachments') && isset($this->attachments) ? asset($this->attachments->path."/".$this->attachments->filename) : asset('assets/images/default-image.jpg');
    }

    public function getImageIdAttribute()
    {
        return $this->relationLoaded('attachments') && isset($this->attachments) ? $this->attachments->id : null;
    }


    protected static function boot()
    {
        parent::boot();
        static::observe(SliderObserver::class);
    }
}
