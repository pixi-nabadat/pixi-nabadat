<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Traits\Filterable;

class CancelReason extends Model
{
    use HasFactory,Filterable,HasTranslations;

    const ACTIVE = 1;
    const NONACTIVE = 0;

    public $translatable = ['reason'];
    protected $fillable = ['reason','is_active'];
}
