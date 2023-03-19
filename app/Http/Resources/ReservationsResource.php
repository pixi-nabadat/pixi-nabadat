<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $lang = getLocale();
        return [
            'id' => $this->id,
            'check_date' => $this->check_date,
            'check_day' => Carbon::parse($this->check_date)->locale($lang)->dayName,
            'qr_code' => $this->qr_code,
            'period' => $this->period,
            'customer' => $this->whenLoaded('user', [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'phone' => $this->user->phone,
                'image' => $this->user->image,
            ]),
            'center' => new CentersResource($this->whenLoaded('center')),
            'status' =>$this->when($this->whenLoaded('latestStatus'),$this->latestStatus->status),
            'nabadat_history' => NabadatHistoryResource::collection($this->whenLoaded('nabadatHistory')),
        ];
    }
}