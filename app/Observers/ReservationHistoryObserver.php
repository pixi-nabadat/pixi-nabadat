<?php

namespace App\Observers;

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
        if($reservationHistory->action_en == Reservation::getStatus('completed','en')){
            $newPoints     = 10;
            $reservation = Reservation::find($reservationHistory->reservation_id);
            $user = User::find($reservation->customer_id);
            $user->update([
                'points'=> $user->points + $newPoints,
                'points_expire_date'=> Carbon::parse(Carbon::now()->addMonths(3))->toDateString()
            ]);
            $reservation->center()->update([
                'points'=> $reservation->center->points + $newPoints,
                'points_expire_date'=> Carbon::parse(Carbon::now()->addMonths(3))->toDateString()
            ]);    
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
