<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NabadatHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'center_id',
        'reservation_id',
        'device_id',
        'num_nabadat',
        'nabada_price',
        'total_price'
    ];
    public function device()
    {
        return $this->belongsTo(Device::class,'device_id');
    }
}
