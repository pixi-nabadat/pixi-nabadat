<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Settings extends Model
{
    use HasFactory , HasTranslations;
    protected $fillable = ['name','value'];
    public $timestamps = false;

    public $translatable = ['value'];


}
