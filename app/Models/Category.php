<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\Filterable;
use App\Traits\HasAttachment;

class Category extends Model
{
    use HasFactory,HasTranslations,HasAttachment,Filterable;
    const ACTIVE = 1;
    const NONACTIVE = 0;

    const CENTERTYPT = 1;
    const USERTYPE = 2;

    public $translatable = ['name'];
    protected $fillable = ['name','is_active','type'];


    public function getTypeAttribute($value)
    {
        return $value == self::CENTERTYPT ? trans('lang.center') : trans('lang.user');
    }
}
