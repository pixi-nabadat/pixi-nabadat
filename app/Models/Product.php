<?php

namespace App\Models;

use App\Enum\ImageTypeEnum;
use App\Traits\EscapeUnicodeJson;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\Filterable;
use App\Traits\HasAttachment;

class Product extends Model
{
    use HasFactory,HasTranslations,Filterable,HasAttachment,EscapeUnicodeJson;

    const Active = 1 ;
    const NONActive = 0 ;

    const PRODUCTCENTER = 1 ;
    const PRODUCTUSER = 2 ;

    const SEARCHFLAG = 1 ;

    protected $fillable = [
        'name','added_by','category_id','description','unit_price','purchase_price','discount',
        'discount_start_date','discount_end_date','tax','tax_type','featured','rate','is_active','stock','type'];

    public $translatable = ['name','description'];

    public function user()
    {
        return $this->belongsTo(User::class,'added_by');
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function scopeActive($builder)
    {
        return $builder->where('is_active',Product::Active);
    }

    public function getProductDiscountAttribute()
    {
        $discount = 0 ;
        $currentDate  = Carbon::now();
        $discountEndDate   = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($this->discount_end_date));
        $discountStartDate = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($this->discount_start_date));
        if($currentDate->gte($discountStartDate) && $currentDate->lt($discountEndDate))
            $discount =  $this->discount;
        return $discount;
    }

    public function rates(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Rate::class, 'ratable');
    }

    public function getTypeAttribute($value)
    {
        return $value == 1 ? trans('lang.center') : trans('lang.user');
    }

    public function getSearchFlagTextAttribute(): string
    {
        return trans('lang.products') ;
    }
    public function getSearchFlagAttribute(): int
    {
        return self::SEARCHFLAG;
    }

    public function defaultLogo(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Attachment::class, 'attachmentable')->where('type', ImageTypeEnum::LOGO);
    }

    public function getImagePathAttribute(): string
    {
        return $this->relationLoaded('defaultLogo') && isset($this->defaultLogo) ? asset($this->defaultLogo->path."/".$this->defaultLogo->filename) : asset('assets/images/default-image.jpg');
    }
}
