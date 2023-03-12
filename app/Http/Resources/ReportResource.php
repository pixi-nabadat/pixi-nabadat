<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
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
            'id' => $this->id,
            'check_date' => $this->check_date,
            'check_day' => Carbon::parse($this->check_date)->dayName,
            'qr_code' => $this->qr_code,
            'from' => $this->from,
            'to' => $this->to,
            'status' =>$this->when($this->whenLoaded('latestStatus'),new ReservationHistoryResource($this->latestStatus)),
        ];
    }
}
