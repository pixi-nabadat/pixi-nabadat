<?php

namespace App\Observers;

use App\Models\ReservationHistory;

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
        cache()->forget('center-home-api');
    }

    /**
     * Handle the ReservationHistory "updated" event.
     *
     * @param  \App\Models\ReservationHistory  $reservationHistory
     * @return void
     */
    public function updated(ReservationHistory $reservationHistory)
    {
        cache()->forget('center-home-api');
    }

    /**
     * Handle the ReservationHistory "deleted" event.
     *
     * @param  \App\Models\ReservationHistory  $reservationHistory
     * @return void
     */
    public function deleted(ReservationHistory $reservationHistory)
    {
        cache()->forget('center-home-api');
    }

    /**
     * Handle the ReservationHistory "restored" event.
     *
     * @param  \App\Models\ReservationHistory  $reservationHistory
     * @return void
     */
    public function restored(ReservationHistory $reservationHistory)
    {
        cache()->forget('center-home-api');
    }

    /**
     * Handle the ReservationHistory "force deleted" event.
     *
     * @param  \App\Models\ReservationHistory  $reservationHistory
     * @return void
     */
    public function forceDeleted(ReservationHistory $reservationHistory)
    {
        cache()->forget('center-home-api');
    }
}
