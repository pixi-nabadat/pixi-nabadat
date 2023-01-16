<?php

namespace App\Observers;

use App\Enum\PaymentStatusEnum;
use App\Models\Center;
use App\Models\CenterFinancial;
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
            $amount_after_discount = $userPackage->price - ($userPackage->price * ($userPackage->center->app_discount / 100));
//          set user points after pay the offer
            User::setPoints(user: $userPackage->user, amount: $amount_after_discount, amountType: 'cash');
//          set center points after pay the offer
            Center::setPoints(center: $userPackage->center, amount: $amount_after_discount, amountType: 'cash');
//          set financial for center and
            CenterFinancial::createFinancial($userPackage);
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
        //
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
