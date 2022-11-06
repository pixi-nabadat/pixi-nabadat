<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory,HasTranslations;
    const ACTIVE = 1;
    const NONACTIVE = 0;
    
    public $translatable = ['name'];
    protected $fillable = ['name','is_active'];
}