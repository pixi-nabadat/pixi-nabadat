<?php

namespace App\Services;

use App\Enum\PaymentMethodEnum;
use App\Enum\PaymentStatusEnum;
use App\Enum\UserPackageStatusEnum;
use App\Exceptions\NotFoundException;
use App\Exceptions\StatusNotEquelException;
use App\Models\Invoice;
use App\Models\Reservation;
use App\Models\ReservationHistory;
use App\Models\Transaction;
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
        else if($status == Reservation::COMPLETED)
            $this->completeReservation(reservation: $reservation);
        $reservation->refresh();
        return true;
    }

    public function completeReservation(Reservation $reservation)
    {
        $reservationPulses   = $reservation->nabadatHistory->sum('num_nabadat');
        $user = $reservation->user;
        $active_user_package = $user->package()->where('status',UserPackageStatusEnum::ONGOING)->where('payment_status',PaymentStatusEnum::PAID)->first();
        $center = $reservation->center;
        if(!$active_user_package)
        {
            //pay cache for all reservation pulses and buy custom pulses
            $data = [
                'center_id'=>$center->id,
                'num_nabadat'=>$reservationPulses,
                'payment_method'=>PaymentMethodEnum::CASH,
            ];
            //call buyCsuomPulsesMethod here
        }else{
            $remainPulses = $active_user_package->remain;
            $newRemain =  $remainPulses - $reservationPulses;
            if($newRemain <= 0){// set status for the next package ingoing
                $notPayedPulses = $reservationPulses - $remainPulses;//the pulses over the package capacity
                $active_user_package->update([
                    'remain'=>0,
                    'used'=>$remainPulses,
                    'status'=>UserPackageStatusEnum::COMPLETED,
                ]);
                $readyUserPackage =  $user->package()->where('status',UserPackageStatusEnum::READYFORUSE)->where('payment_status',PaymentStatusEnum::PAID)->orderByDesc('id')->first();
                if($readyUserPackage)
                {
                    $readyUserPackage->update([
                        'remain'=>$readyUserPackage->remain - $notPayedPulses,
                        'used'=>$notPayedPulses,
                        'status'=>UserPackageStatusEnum::ONGOING,
                    ]);
                }else{
                    $data = [
                        'center_id'=>$center->id,
                        'num_nabadat'=>$notPayedPulses,
                        'payment_method'=>PaymentMethodEnum::CASH,
                    ];
                    //call buyCsuomPulsesMethod here
                }

            }else{
                $active_user_package->remain = $newRemain;
                $active_user_package->used = $active_user_package->used + $reservationPulses;
            }
        }

    }
}