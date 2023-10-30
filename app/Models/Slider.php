<?php

namespace App\Models;

use App\Observers\SliderObserver;
use App\Traits\Filterable;
use App\Traits\HasAttachment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory, Filterable, HasAttachment;

    const CENTER  = 1 ;
    const PRODUCT = 2 ;
    const SLIDERABLE_TAYPES = [
        self::CENTER,self::PRODUCT
    ];

    protected $fillable = ['order', 'sliderable_type', 'sliderable_id', 'start_date', 'end_date', 'is_active', 'type'];

    public function sliderable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function attachments(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachmentable');
    }

    public function scopeActive(Builder $builder): void
    {
        $builder->where('start_date' ,  '<=' , Carbon::now(config('app.africa_timezone'))->format('Y-m-d'))->where('end_date' ,  '>=' , Carbon::now(config('app.africa_timezone'))->format('Y-m-d'));
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
