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
        'payment_method', 'payment_status', 'status', 'used', 'remain', 'expire_date',
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

    public static function getNextReadyPackage(User $user, int $center_id): bool
    {
        $currentOngoingPackage = $user->package()->where('center_id', $center_id)->where('status',UserPackageStatusEnum::ONGOING)->first();
        $currentOngoingPackage->remain = 0;
        $currentOngoingPackage->used = $currentOngoingPackage->num_nabadat;
        $currentOngoingPackage->status = UserPackageStatusEnum::COMPLETED;
        $currentOngoingPackage->save();
        $currentOngoingPackage->refresh();

        $nextOngoingPackage = $user->package()->where('center_id', $center_id)->where('status',UserPackageStatusEnum::READYFORUSE)->orderBy('id','desc')->first();
        if(!$nextOngoingPackage)
        {
            return false;
        }else{
            $nextOngoingPackage->status = UserPackageStatusEnum::ONGOING;
            $nextOngoingPackage->save();  
            return true;
        }
    }

    //this method is used in expire user package command only
    public static function getNextReadyPackageForExpirePackage(User $user, UserPackage $userPackage): bool
    {
        $userPackage->status = UserPackageStatusEnum::EXPIRED;
        $userPackage->save();
        $userPackage->refresh();
        $user->decreaseUserWalletForExpirePackage($userPackage->remain);
        $currentOngoingPackage = $user->package()->where('center_id', $userPackage->center_id)->where('status',UserPackageStatusEnum::ONGOING)->first();
        if(!$currentOngoingPackage)
        {
            $nextOngoingPackage = $user->package()->where('center_id', $userPackage->center_id)->where('status',UserPackageStatusEnum::READYFORUSE)->orderBy('id','desc')->first();
            if(!$nextOngoingPackage)
            {
                return false;
            }else{
                $nextOngoingPackage->status = UserPackageStatusEnum::ONGOING;
                $nextOngoingPackage->save();  
                return true;
            }
        }
        return true;
        
    }

    public function getStatusAsString(int $status)
    {
        return match((int)$status){
            UserPackageStatusEnum::ONGOING => trans('lang.ongoing'),
            UserPackageStatusEnum::READYFORUSE => trans('lang.ready_for_use'),
            UserPackageStatusEnum::PENDING => trans('lang.pending'),
            UserPackageStatusEnum::COMPLETED => trans('lang.completed'),
            UserPackageStatusEnum::EXPIRED => trans('lang.expired'),

        };
    }

    protected static function boot()
    {
        parent::boot();
        static::observe(UserPackageObserver::class);
    }
}
