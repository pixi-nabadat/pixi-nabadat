<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    // use HasFactory, Filterable;
    use HasFactory,Filterable;
    const PRODUCT        = 1 ;
    const CENTER_DEVICE  = 2 ;
    const CENTER         = 3 ;
    const RATABLE_TAYPES = [
        self::PRODUCT,self::CENTER_DEVICE,self::CENTER
    ];
    protected $fillable = ['user_id','is_active','comment','rate_number','ratable_id','ratable_type'];

    public function ratable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
