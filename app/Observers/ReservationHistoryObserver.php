<?php

namespace App\Observers;

use App\Enum\PaymentStatusEnum;
use App\Enum\UserPackageStatusEnum;
use App\Exceptions\NotFoundException;
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
        cache()->forget('center-home-api');
//        To check if not used remove it
        if($reservationHistory->status == Reservation::COMPLETED){
            $reservation = $reservationHistory->reservation;
            $reservationPulses   = $reservation->nabadatHistory->sum('num_nabadat');
            $user = $reservationHistory->user;
            $active_user_package = $user->package()->where('status',UserPackageStatusEnum::ONGOING)->where('payment_status',PaymentStatusEnum::PAID);
            $active_user_package_count = $active_user_package->count();

            if(!$active_user_package_count)
                throw new NotFoundException(trans('lang.there_is_no_ingoing_packages'));

            $newRemain = $active_user_package->remain - $reservationPulses;
            if($newRemain <= 0)// set status for the next package ingoing
                throw new NotFoundException(trans('lang.there_is_no_enough_pulses'));
            $active_user_package->remain = $newRemain;
            $active_user_package->used = $active_user_package->used + $reservationPulses;

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
