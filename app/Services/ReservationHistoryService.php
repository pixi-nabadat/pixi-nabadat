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
        $lastStatus = $reservation->history->last()->getRawOriginal('status');

        $reservationDevicesCount = $reservation->nabadatHistory->count();

        $status = $reservation_data['status'] ;

        if($lastStatus == Reservation::CANCELED || $lastStatus == Reservation::Expired)
            throw new StatusNotEquelException(trans('lang.the_current_status_is: ') . Reservation::getStatusText($lastStatus));
        if ($status == Reservation::CONFIRMED && $lastStatus != Reservation::PENDING)
            throw new StatusNotEquelException(trans('lang.the_current_status_is: ') . Reservation::getStatusText($lastStatus));
        elseif ($status == Reservation::ATTEND && $lastStatus != Reservation::CONFIRMED)
            throw new StatusNotEquelException(trans('lang.the_current_status_is: ') . Reservation::getStatusText($lastStatus));
        elseif($status == Reservation::COMPLETED && ($lastStatus != Reservation::ATTEND || $reservationDevicesCount == 0))
            throw new StatusNotEquelException(trans('lang.the_current_status_is: ') . Reservation::getStatusText($lastStatus).' '.trans('lang.and_devices_count_is: ') .$reservationDevicesCount);
        elseif ($status ==Reservation::CANCELED && $lastStatus == Reservation::COMPLETED)
            throw new StatusNotEquelException(trans('lang.the_current_status_is: ') . Reservation::getStatusText($lastStatus));
        else
            return $this->setStatusAndUpdateReservationTime(reservation: $reservation, reservation_data: $reservation_data);
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
