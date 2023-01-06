<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CenterFinancial extends Model
{
    use HasFactory;

    protected $fillable = [
        'center_id','num_nabadat','package_id','center_dues','app_dues','status','date','regular_price','discount',
    ];

    public function center():BelongsTo
    {
        return $this->belongsTo(Center::class, 'center_id');
    }
}
