<?php

namespace App\Observers;

use App\Enum\UserPackageStatusEnum;
use App\Models\Reservation;
use App\Models\ReservationHistory;
use App\Models\User;
use Carbon\Carbon;

class ReservationHistoryObserver
{
    /**
     * Handle the ReservationHistory "created" event.
     *
     * @param  \App\Models\ReservationHistory  $reservationHistory
     * @return void
     */
    public function created(ReservationHistory $reservationHistory)
    {
        if($reservationHistory->status == Reservation::COMPLETED){
            $reservation = $reservationHistory->reservation;
            $usedTotalNabadat   = $reservation->nabadatHistory->sum('num_nabadat');
            $user = $reservation->user;
            $onGoingPackage = $user->package()->where('usage_status', UserPackageStatusEnum::ONGOING)->first();
            if($onGoingPackage)
            {
                $packageNabadat = $onGoingPackage->num_nabadat;
                if(($packageNabadat - $usedTotalNabadat) < 0)
                    return false;// this will be modified and get the next payed package
                else
                {
                    $onGoingPackage->used += $usedTotalNabadat;
                    $onGoingPackage->save();
                }
            }
        }
    }

    /**
     * Handle the ReservationHistory "updated" event.
     *
     * @param  \App\Models\ReservationHistory  $reservationHistory
     * @return void
     */
    public function updated(ReservationHistory $reservationHistory)
    {
        //
    }

    /**
     * Handle the ReservationHistory "deleted" event.
     *
     * @param  \App\Models\ReservationHistory  $reservationHistory
     * @return void
     */
    public function deleted(ReservationHistory $reservationHistory)
    {
        //
    }

    /**
     * Handle the ReservationHistory "restored" event.
     *
     * @param  \App\Models\ReservationHistory  $reservationHistory
     * @return void
     */
    public function restored(ReservationHistory $reservationHistory)
    {
        //
    }

    /**
     * Handle the ReservationHistory "force deleted" event.
     *
     * @param  \App\Models\ReservationHistory  $reservationHistory
     * @return void
     */
    public function forceDeleted(ReservationHistory $reservationHistory)
    {
        //
    }
}
