<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;
    const PRODUCT = 1 ;
    const DEVICE = 2 ;
    const CENTER = 3 ;
    const RATABLE_TAYPES = [
        self::PRODUCT,self::DEVICE,self::CENTER
    ];
    protected $fillable = ['user_id','status','comment','rate_number','ratable_id','ratable_type'];

    public function ratable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
