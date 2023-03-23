<?php

namespace App\Observers;

use App\Enum\PaymentStatusEnum;
use App\Models\Center;
use App\Models\Invoice;
use App\Models\Settlement;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserPackage;
use App\Services\UserPackageService;
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
        app()->make(UserPackageService::class)->completeUserPackage(userPackage: $userPackage);

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
            app()->make(UserPackageService::class)->completeUserPackage(userPackage: $userPackage);

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
