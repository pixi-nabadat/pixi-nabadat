<?php

namespace App\Models;

use App\Observers\UserPackageObserver;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPackage extends Model
{
    use HasFactory,Filterable;

    protected $fillable = [
        'num_nabadat',
        'price',
        'center_id',
        'user_id',
        'package_id',
        'discount_percentage',
        'payment_method',
        'payment_status',
        'usage_status',
        'used',
        'remaining',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class, 'center_id');
    }
    protected static function boot()
    {
        parent::boot();
        static::observe(UserPackageObserver::class);
    }
}
