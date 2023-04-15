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

    public function logo(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachmentable');
    }

    public function getImagePathAttribute(): string
    {
        return $this->relationLoaded('logo') && isset($this->logo) ? asset($this->logo->path . "/" . $this->logo->filename) : asset('assets/images/default-image.jpg');
    }

    protected static function boot()
    {
        parent::boot();
        static::observe(SliderObserver::class);
    }
}
