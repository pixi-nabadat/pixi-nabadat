<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\User;
use App\QueryFilters\CouponsFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
class CouponUsageService extends BaseService
{
    public function store(array $data = [])
    {
        $user   = Auth::user();
        //get coupon to check exists
        $coupon = Coupon::firstWhere('code', $data['code']);

        $response = $this->simulation($data);

        if($response['status']){
            $user->coupons()->attach(
                $coupon->id,['temp_user_id' => $data['serial']]
            );
            $cart = $user->cart->first();

            $cart->net_total = $response['data'];
            $cart->save();
            $cart->refresh();
            return ['status'=> true, 'data'=> $cart];
        }
        else
            return $response;

    }
    public function simulation(array $data = []): array
    {
        $user   = Auth::user();
        //get coupon to check exists
        $coupon = Coupon::firstWhere('code', $data['code']);

        //get usage count of coupon
        $usage  = $user->coupons()->where('coupon_id', $coupon->id)->count();

        //get coupon limit to check times of usages this coupon
        $couponLimit = $coupon->coupon_limit;

        //get the cart net_total to check with coupon min_buy
        $netTotal = $user->cart->net_total;

        /**
         * start checking if coupon valid or not
         */
        $currentDate       = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::today());
        $discountStartDate = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($coupon->start_date));
        $discountEndDate   = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($coupon->end_date));

        if($coupon == null)
            return ['status'=>false, 'message'=> 'Coupon Not Found'];
        else if($usage >= $couponLimit)
            return ['status'=>false, 'message'=> "You can'nt use this coupon again."];
        else if(!$currentDate->gte($discountStartDate))
            return ['status'=>false, 'message'=> "The Coupon Not Started."];
        else if(!$currentDate->lt($discountEndDate))
            return ['status'=>false, 'message'=> "The Coupon Expired."];
        else if($coupon->min_buy > $netTotal)
            return ['status'=>false, 'message'=> "your purchase balance less than coupon balance"];
        else{

            $discount_type = $coupon->discount_type;
            $newBalance = 0;
            if($discount_type == 'percent'){
                $newDiscount = ($netTotal * ($coupon->discount/100)) * ($usage + 1);
                $newBalance = $netTotal- $newDiscount;
            }else{
                $newBalance = $netTotal- ($coupon->discount * ($usage + 1));
            }

            return ['status'=>true, 'data'=> $newBalance];
        }
        /**
         * end check if the coupon valid or not
         */

    } //end of store

}
