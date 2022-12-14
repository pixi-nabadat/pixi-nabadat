<?php

namespace App\Models;

use App\Traits\EscapeUnicodeJson;
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

    protected $fillable = [
        'name','added_by','category_id','description','unit_price','purchase_price','discount',
        'discount_type','discount_start_date','discount_end_date','tax','tax_type', 'estimation','featured','is_active','stock'];

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

    public function getDiscountTypeAttribute($value)
    {
        return $value == 0 ? trans('lang.flat') : trans('lang.percent');
    }

    public function estimations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductEstimation::class,'product_id');
    }
}
