<?php

namespace App\Observers;

use App\Enum\PaymentStatusEnum;
use App\Models\Center;
use App\Models\Invoice;
use App\Models\Settlement;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserPackage;
use Carbon\Carbon;

class UserPackageObserver
{
    /**
     * Handle the UserPackage "created" event.
     *
     * @param \App\Models\UserPackage $userPackage
     * @return void
     */
    public function created(UserPackage $userPackage)
    {
        //user after paid for package earn point
        if ($userPackage->payment_status == PaymentStatusEnum::PAID) {
            $userPackage->load(['center','user']);
            $user_amount_for_points = $userPackage->price - ($userPackage->price * ($userPackage->center->pulse_discount / 100));
//          set user points after pay the offer
            User::setPoints($userPackage->user, amount: $user_amount_for_points);
//          set center points after pay the offer
            User::setPoints($userPackage->center->user, amount: $user_amount_for_points);
//          set financial for center
            $final_discount_for_nabadat_company = $userPackage->center->app_discount - $userPackage->discount_percentage;
            $center_dues = $userPackage->price - ($userPackage->price * ($userPackage->center->app_discount / 100));
            $nabadat_app_dues =($final_discount_for_nabadat_company > 0) ?  ($userPackage->price - $center_dues - ($userPackage->price * $final_discount_for_nabadat_company/ 100)):0;
            $invoice = Invoice::where('center_id',$userPackage->center->id)->where('status',Invoice::PENDING)->orderByDesc('id')->first();
            if ($invoice)
            {
                $center_dues = $invoice->total_center_dues + $center_dues ;
                $nabadat_app_dues = $invoice->total_nabadat_dues + $nabadat_app_dues;
                $invoice->update(['total_center_dues'=>$center_dues, 'total_nabadat_dues'=>$nabadat_app_dues]);
            }else
            {
                $invoice = Invoice::create(['total_center_dues'=>$center_dues, 'total_nabadat_dues'=>$nabadat_app_dues,'center_id'=>$userPackage->center->id]);
            }
            Transaction::createTransaction($userPackage,$invoice->id);
        }
    }

    /**
     * Handle the UserPackage "updating" event.
     *
     * @param \App\Models\UserPackage $userPackage
     * @return void
     */
    public function updating(UserPackage $userPackage)
    {
        if($userPackage->isDirty('payment_status'))
        {
            //user after paid for package earn point
            if ($userPackage->payment_status == PaymentStatusEnum::PAID) {
                $userPackage->load(['center','user']);
                $user_amount_for_points = $userPackage->price - ($userPackage->price * ($userPackage->center->pulse_discount / 100));
    //          set user points after pay the offer
                User::setPoints($userPackage->user, amount: $user_amount_for_points);
    //          set center points after pay the offer
                User::setPoints($userPackage->center->user, amount: $user_amount_for_points);
    //          set financial for center
                $final_discount_for_nabadat_company = $userPackage->center->app_discount - $userPackage->discount_percentage;
                $center_dues = $userPackage->price - ($userPackage->price * ($userPackage->center->app_discount / 100));
                $nabadat_app_dues =($final_discount_for_nabadat_company > 0) ?  ($userPackage->price - $center_dues - ($userPackage->price * $final_discount_for_nabadat_company/ 100)):0;
                $invoice = Invoice::where('center_id',$userPackage->center->id)->where('status',Invoice::PENDING)->orderByDesc('id')->first();
                if ($invoice)
                {
                    $center_dues = $invoice->total_center_dues + $center_dues ;
                    $nabadat_app_dues = $invoice->total_nabadat_dues + $nabadat_app_dues;
                    $invoice->update(['total_center_dues'=>$center_dues, 'total_nabadat_dues'=>$nabadat_app_dues]);
                }else
                {
                    $invoice = Invoice::create(['total_center_dues'=>$center_dues, 'total_nabadat_dues'=>$nabadat_app_dues,'center_id'=>$userPackage->center->id]);
                }
                Transaction::createTransaction($userPackage,$invoice->id);
            }
        }
    }
    /**
     * Handle the UserPackage "updated" event.
     *
     * @param \App\Models\UserPackage $userPackage
     * @return void
     */
    public function updated(UserPackage $userPackage)
    {
//        ToDo when user package update payment status to paid
//       ToDo update nabadat user wallet
    }

    /**
     * Handle the UserPackage "deleted" event.
     *
     * @param \App\Models\UserPackage $userPackage
     * @return void
     */
    public function deleted(UserPackage $userPackage)
    {
        //
    }

    /**
     * Handle the UserPackage "restored" event.
     *
     * @param \App\Models\UserPackage $userPackage
     * @return void
     */
    public function restored(UserPackage $userPackage)
    {
        //
    }

    /**
     * Handle the UserPackage "force deleted" event.
     *
     * @param \App\Models\UserPackage $userPackage
     * @return void
     */
    public function forceDeleted(UserPackage $userPackage)
    {
        //
    }
}
