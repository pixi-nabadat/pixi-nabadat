<?php

namespace App\Services;

use App\Exceptions\StatusNotEquelException;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Center;
use App\QueryFilters\ReservationsFilter;
use Exception;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
class ReservationHistoryService extends BaseService
{
    private function setStatus(Reservation $reservation,string $status,User $user = null): bool
    {
        $reservation->history()->create([
            'user_id'   =>$user->id,
            'action_en' =>Reservation::getStatus($status,'en'),
            'action_ar' =>Reservation::getStatus($status, 'ar')
        ]);
        $reservation->refresh();
        return true;
    }

    public function store(User $user, Reservation $reservation, string $status)
    {
        $lastStatus = $reservation->history->last()->action_en;

        $reservationDevicesCount = $reservation->nabadatHistory->count();

        if($status== 'confirm' && ($lastStatus == Reservation::getStatus('pending','en')))//confirm status
            return $this->setStatus(reservation: $reservation, status: $status, user: $user);
        else if($status== 'attend' && ($lastStatus == Reservation::getStatus('confirm','en')))//attend status
            return $this->setStatus(reservation: $reservation, status: $status, user: $user);
        else if($status== 'completed' && ($lastStatus == Reservation::getStatus('attend','en') && $reservationDevicesCount > 0))//complete status
            return $this->setStatus(reservation: $reservation, status: $status, user: $user);
        else if($status== 'canceled' && ($lastStatus != Reservation::getStatus('completed','en') && $lastStatus != Reservation::getStatus('canceled','en') && $lastStatus != Reservation::getStatus('expired','en')))//cancel status
            return $this->setStatus(reservation: $reservation, status: $status, user: $user);
        else
            throw new StatusNotEquelException('the status is: '.$lastStatus );
    }


}
