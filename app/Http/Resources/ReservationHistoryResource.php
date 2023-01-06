<?php

namespace App\Http\Resources;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationHistoryResource extends JsonResource
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
            'user'      => $this->whenLoaded('user') ? new AuthUserResource($this->user):null,
            'action_en' => $this->action_en,
            'action_ar' => $this->action_ar,
            'created_at'=> Carbon::parse($this->created_at)->format('d-m-Y')
        ];
    }
}
