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
        $reservation = Reservation::find($data['reservation_id']);
        if($reservation != null){
            $device = Device::find($data['device_id']);
            if($device)
                $nabadaPrice = $device->value('price');
            $centerId = $reservation->center()->value('id');
            $reservation->nabadatHistory()->create([
                'user_id'      => Auth::user()->id,
                'device_id'    => $data['device_id'],
                'center_id'    => $centerId,
                'num_nabadat'  => $data['num_nabadat'],
                'nabada_price' => $nabadaPrice,
                'total_price'  => $data['num_nabadat'] * $nabadaPrice
            ]);
            $reservation->refresh();
            return $reservation;
        }else{
            return false;
        }
        
        
    }
}
