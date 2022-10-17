<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Kalnoy\Nestedset\NodeTrait;
use App\Traits\Filterable;

class Location extends Model
{
    use NodeTrait, HasTranslations, HasFactory, Filterable;

    protected $fillable = [
        'slug', 'currency_id', 'is_active', 'lft' ,'rgt','title','created_by','_lft','_lft','parent_id'
    ];

    protected $table = 'locations';
    public $timestamps = false;

    public $translatable = ['title'];


}
