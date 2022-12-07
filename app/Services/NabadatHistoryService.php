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
            $centerId = $reservation->center_id;
            $center = Center::find($centerId);
            $centerDevice = $center->devices()->where('device_id', $data['device_id'])->first();
            if($centerDevice){
                if($data['auto_service'])
                    $nabadaPrice = $centerDevice->pivot->unit_price_with_auto_service;
                else
                    $nabadaPrice = $centerDevice->pivot->unit_price;
            }
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
