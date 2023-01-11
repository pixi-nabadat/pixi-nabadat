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

    public static function decreaseFromUserOffer($number_of_pulses)
    {
        if ($number_of_pulses == 0)
            return true ;
        $activeUserPackage = UserPackage::where('status','!=',UserPackageStatusEnum::COMPLETED)->where('payment_status',PaymentStatusEnum::PAID)->where('remain','!=',0)->first();
        if ($activeUserPackage)
        {
            if ($number_of_pulses > $activeUserPackage->remain)
            {
                $remain_pulses = $number_of_pulses - $activeUserPackage->remain ;
                $activeUserPackage->remain = 0 ;
                $activeUserPackage->used_amount = $activeUserPackage->used_amount + $activeUserPackage->remain ;
                $activeUserPackage->status = UserPackageStatusEnum::COMPLETED ;
                $activeUserPackage->save();
                $activeUserPackage->refresh();
                self::decreaseFromUserOffer($remain_pulses);
            }else{
                $old_remain = $activeUserPackage->remain ;
                $activeUserPackage->remain = $old_remain-$number_of_pulses ;
                if ($old_remain - $number_of_pulses == 0)
                    $activeUserPackage->status = UserPackageStatusEnum::COMPLETED ;
                $activeUserPackage->save();
            }
        }

        if (!$activeUserPackage && $number_of_pulses)
        {
            //todo register it in financial
        }
    }

}
