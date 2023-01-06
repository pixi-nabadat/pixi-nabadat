<?php

namespace App\Models;

use App\Observers\UserPackageObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPackage extends Model
{
    use HasFactory;


    protected $fillable = ['user_id', 'package_id', 'num_nabadat', 'price','percentage','center_id','payment-status','payment_type','status','used_amount','remain'];

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
        return $this->belongsTo(Center::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::observe(UserPackageObserver::class);
    }
}
