<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CentersResource;
class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'customer'=> AuthUserResource::collection($this->customer_id),
            'center'=>CentersResource::collection($this->center),
            'reservation_date'=> $this->reservation_date,
            'check_date'=> $this->check_date,
            'reservation_status'=> $this->reservation_status,
            'payment_type'=> $this->payment_type,
            'payment_status'=> $this->payment_status,
            'qr_code'=> $this->qr_code,
        ];
    }
}
