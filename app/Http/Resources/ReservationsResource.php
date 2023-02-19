<?php

namespace App\Http\Resources;

use App\Http\Resources\CentersResource;
use App\Models\Reservation;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ReservationsResource extends JsonResource
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
            'id'              => $this->id,
            'check_date'      => $this->check_date,
            'check_day'       => Carbon::parse($this->check_date)->dayName,
            'qr_code'         => $this->qr_code,
            'from'            => $this->from,
            'to'              => $this->to,
            'customer'        => $this->whenLoaded('user',[
                'id'=>$this->user->id,
                'name'=>$this->user->name,
                'phone'=>$this->user->phone,
            ]),
            'center'          => $this->whenLoaded('center',new CentersResource($this->center)),
            'status'          => $this->whenLoaded('latestStatus',$this->reservation_status),
            'nabadat_history' => $this->whenLoaded('nabadatHistory') ? NabadatHistoryResource::collection($this->nabadatHistory):null,
        ];
    }
}
