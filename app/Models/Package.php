<?php

namespace App\Models;

use App\Enum\PackageStatusEnum;
use App\Traits\EscapeUnicodeJson;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\HasAttachment;

class Package extends Model
{
    use HasFactory,Filterable,HasTranslations,HasAttachment,EscapeUnicodeJson;

    protected $fillable = ['center_id','name','num_nabadat','price','start_date','end_date','discount_percentage','status','is_active'];
    public $translatable =['name'];

    public function subscriber(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(UserPackage::class);
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class);
    }

    public function getStatusAttribute($value)
    {
        switch ($value){
            case PackageStatusEnum::UNDERACHIEVING:
                return trans('lang.under_reviewing') ;
            case PackageStatusEnum::APPROVED:
                return trans('lang.approved') ;
            case PackageStatusEnum::REJECTED:
                return trans('lang.rejected') ;
        }
    }

    public function getUserPriceAttribute(): float
    {
        return $this->price*((100 - $this->discount_percentage)/100);
    }
}
