<?php

namespace App\Observers;

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
        $pointPerPound = 2;// this value will come from settings
        $user = $userPackage->user;
        $newPoints = $userPackage->price * $pointPerPound;
        $totalPoints = $user->points + $newPoints;
        $user->update([
            'points' => $totalPoints,
            'points_expire_date' => Carbon::parse(Carbon::now()->addMonths(3))->toDateString()//these months addded will come from settings
        ]);
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
