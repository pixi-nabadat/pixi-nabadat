<?php

namespace App\Models;

use App\Enum\ImageTypeEnum;
use App\Traits\HasAttachment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class CenterDevice extends Model
{
    use HasFactory,Filterable,HasAttachment;
    protected $fillable = ['center_id','device_id','number_of_devices', 'auto_service','is_active'];


    public function center(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Center::class,'center_id');
    }

    public function device(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Device::class,'device_id');
    }

    public function rates(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Rate::class, 'ratable');
    }

    public function getPrimaryImagePathAttribute(): string
    {
        $attachment = $this->attachments->where('type',ImageTypeEnum::LOGO)->first();
        if ($this->relationLoaded('attachments') && isset($attachment))
        {
            return asset($attachment->path."/".$attachment->filename);
        }else
            return asset('assets/images/default-image.jpg');
    }
}
