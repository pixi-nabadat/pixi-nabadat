<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\Filterable;

class Currency extends Model
{
    use HasTranslations, HasFactory,Filterable;

    protected $fillable = [
        'name', 'code', 'symbol',
    ];

    protected $table = 'currencies';

    public $timestamps = false;

    public $translatable = ['name'];
}
