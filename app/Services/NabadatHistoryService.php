<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Exceptions\StatusNotEquelException;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Center;
use App\Models\Device;
use App\QueryFilters\ReservationsFilter;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
class NabadatHistoryService extends BaseService
{


    public function store(array $data = [])
    {
        $reservation = Reservation::with('center')->find($data['reservation_id']);
        if($reservation->latestStatus->getRawOriginal('status') != Reservation::ATTEND)
            throw new Exception(trans('lang.not_allowed'));
        // $user = $reservation->user;
        // $center = $reservation->center;
        if (!$reservation)
           throw new NotFoundException(trans('lang.reservation_not_found'));
        $data['auto_service'] = $data['auto_service'] ?? 0;
        
        $reservation->nabadatHistory()->create([
            'user_id'=>$reservation->customer_id,
            'center_id'=>$reservation->center_id,
            'device_id'=>$data['device_id'],
            'num_nabadat'  => $data['num_nabadat'],
            'auto_service'  => $data['auto_service'],
        ]);
        $reservation->refresh();
        // app()->make(UserPackageService::class)->decreaseFromOffer(user: $user, center: $center, number_of_pulses: $data['num_nabadat']);
        return $reservation->load(['center','user','history']);
    }
}