<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\Translatable\HasTranslations;

class Location extends Model
{
    use HasFactory,HasTranslations,NodeTrait;
    protected $fillable = [
        'slug', 'iso_code_3', 'iso_code_2', 'currency_id', 'is_active', 'lft' ,'rgt','title','created_by','_lft','_lft','parent_id'
    ];
    public $translatable = ['title'];

//    public function getLftName()
//    {
//        return 'left';
//    }
//
//    public function getRgtName()
//    {
//        return 'right';
//    }
//
//    public function getParentIdName()
//    {
//        return 'parent';
//    }
}

