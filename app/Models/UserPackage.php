<?php

namespace App\Models;

use App\Observers\UserPackageObserver;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPackage extends Model
{
    use HasFactory,Filterable,SoftDeletes;

    protected $fillable = [
        'num_nabadat', 'price', 'center_id', 'user_id', 'package_id', 'discount_percentage',
        'payment_method', 'payment_status', 'status', 'used', 'remain', 'deleted_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function center(): BelongsTo
    {
        return $this->belongsTo(Center::class)->with('user:id,center_id,name');
    }

    protected static function boot()
    {
        parent::boot();
        static::observe(UserPackageObserver::class);
    }
}
