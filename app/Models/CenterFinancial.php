<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CenterFinancial extends Model
{
    use HasFactory;

    protected $fillable = [
        'center_id','package_id','num_palses','center_dues','app_dues','regular_price','discount','status','date',
    ];

    public function center():BelongsTo
    {
        return $this->belongsTo(Center::class, 'center_id');
    }
}
