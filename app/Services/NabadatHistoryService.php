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
        $data['auto_service'] = isset($data['auto_service']);
        if (!$reservation)
            return false ;
        $centerDevice = $reservation->center->devices()->where('device_id', $data['device_id'])->first();
        if (!$centerDevice)
            return false ;
        $nabadaPrice = $data['auto_service'] ? $centerDevice->pivot->auto_service_price : $centerDevice->pivot->nabadat_app_price;
        $reservation->nabadatHistory()->create([
            'user_id'      => $reservation->customer_id,
            'device_id'    => $data['device_id'],
            'center_id'    => $reservation->center_id,
            'num_nabadat'  => $data['num_nabadat'],
            'nabada_price' => $nabadaPrice,
            'total_price'  => $data['num_nabadat'] * $nabadaPrice
        ]);
        $reservation->refresh();
        return $reservation->load(['center','user','history']);
    }
}
