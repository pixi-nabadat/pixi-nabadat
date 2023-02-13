<?php

namespace App\Services;

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
        if (!$reservation)
            return false ;
        $data['auto_service'] = isset($data['auto_service']) ? 1 : 0;
        $reservation->nabadatHistory()->updateOrCreate([
            'user_id'=>$reservation->customer_id,
            'center_id'=>$reservation->center_id,
            'device_id'=>$data['device_id'],
        ],[
            'num_nabadat'  => $data['num_nabadat'],
            'auto_service'  => $data['auto_service'],
        ]);
        $reservation->refresh();
        return $reservation->load(['center','user','history']);
    }
}
