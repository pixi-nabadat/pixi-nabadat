<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Device extends Model
{
    use HasFactory,HasTranslations,Filterable;

    public $translatable =['name','description'];
    protected $fillable  =['name','description','image'];
}
