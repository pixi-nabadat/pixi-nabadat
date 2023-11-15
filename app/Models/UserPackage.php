<?php

namespace App\Models;

use App\Enum\UserPackageStatusEnum;
use App\Observers\UserPackageObserver;
use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPackage extends Model
{
    use HasFactory,Filterable;

    protected $fillable = [
        'num_nabadat', 'price', 'center_id', 'user_id', 'package_id', 'discount_percentage',
        'payment_method', 'payment_status', 'status', 'used', 'remain',
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

    public static function getNextReadyPackage(User $user): bool
    {
        $currentOngoingPackage = $user->package()->where('status',UserPackageStatusEnum::ONGOING)->first();
        $currentOngoingPackage->remain = 0;
        $currentOngoingPackage->used = $currentOngoingPackage->num_nabadat;
        $currentOngoingPackage->status = UserPackageStatusEnum::COMPLETED;
        $currentOngoingPackage->save();
        $currentOngoingPackage->refresh();

        $nextOngoingPackage = $user->package()->where('status',UserPackageStatusEnum::READYFORUSE)->orderBy('id','desc')->first();
        if(!$nextOngoingPackage)
        {
            return false;
        }else{
            $nextOngoingPackage->status = UserPackageStatusEnum::ONGOING;
            $nextOngoingPackage->save();  
            return true;
        }
    }

    protected static function boot()
    {
        parent::boot();
        static::observe(UserPackageObserver::class);
    }
}
