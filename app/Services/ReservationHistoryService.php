<?php

namespace App\Services;

use App\Exceptions\StatusNotEquelException;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Arr;

class ReservationHistoryService extends BaseService
{
    /**
     * @throws StatusNotEquelException
     */
    public function store(Reservation $reservation, array $reservation_data = []): bool
    {
        $lastStatus = $reservation->history->last()->status;

        $reservationDevicesCount = $reservation->nabadatHistory->count();

        $status = $reservation_data['status'] ;
        if ($status == Reservation::CONFIRMED && $lastStatus == Reservation::PENDING)
            return $this->setStatusAndUpdateReservationTime(reservation: $reservation, reservation_data: $reservation_data);
        elseif ($status ==Reservation::ATTEND && $lastStatus == Reservation::CONFIRMED)
            return $this->setStatusAndUpdateReservationTime(reservation: $reservation, reservation_data: $reservation_data);
        elseif($status == Reservation::COMPLETED && $lastStatus == Reservation::ATTEND && $reservationDevicesCount > 0)
            return $this->setStatusAndUpdateReservationTime(reservation: $reservation, reservation_data: $reservation_data);
        elseif ($status ==Reservation::CANCELED && $lastStatus != Reservation::COMPLETED && $lastStatus != Reservation::CANCELED && $lastStatus != Reservation::Expired)
            return $this->setStatusAndUpdateReservationTime(reservation: $reservation, reservation_data: $reservation_data);
        else
            throw new StatusNotEquelException(trans('lang.the current status is:') . Reservation::getStatusText($lastStatus) . " new status must be ". Reservation::getStatusText($lastStatus+1));
    }

    private function setStatusAndUpdateReservationTime(Reservation $reservation, array $reservation_data): bool
    {
        $status = $reservation_data['status'];
        $reservation->history()->create([
            'status' => $status,
        ]);
        if ($status == Reservation::CONFIRMED)
            $reservation->update(Arr::except($reservation_data,'status'));
        $reservation->refresh();
        return true;
    }
}
