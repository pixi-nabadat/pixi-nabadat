<?php

namespace App\Models;

use App\Enum\PaymentStatusEnum;
use App\Enum\UserPackageStatusEnum;
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

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function center(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Center::class);
    }
}
