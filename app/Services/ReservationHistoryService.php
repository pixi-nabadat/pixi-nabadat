<?php

namespace App\Services;

use App\Exceptions\StatusNotEquelException;
use App\Models\Reservation;
use App\Models\User;

class ReservationHistoryService extends BaseService
{
    /**
     * @throws StatusNotEquelException
     */
    public function store(User $user, Reservation $reservation, string $status)
    {
        $lastStatus = $reservation->history->last()->status;

        $reservationDevicesCount = $reservation->nabadatHistory->count();

        switch ($status) {
            case $status == Reservation::ATTEND && ($lastStatus == Reservation::CONFIRMED):
            case $status == Reservation::COMPLETED && ($lastStatus == Reservation::PENDING):
            case $status == Reservation::COMPLETED && ($lastStatus == Reservation::ATTEND && $reservationDevicesCount > 0):
            case $status == Reservation::CANCELED && ($lastStatus != Reservation::COMPLETED
                    && $lastStatus != Reservation::CANCELED
                    && $lastStatus != Reservation::Expired):
                return $this->setStatus(reservation: $reservation, status: $status, user: $user);
            default:
                throw new StatusNotEquelException(trans('lang.the status is:') . $lastStatus);
        }

    }

    private function setStatus(Reservation $reservation, int $status, User $user = null): bool
    {
        $reservation->history()->create([
            'user_id' => $user->id,
            'status' => $status,
        ]);
        $reservation->refresh();
        return true;
    }
}
