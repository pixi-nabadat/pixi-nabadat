<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class nabadatHistoryResource extends JsonResource
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
            'user'         => $this->user_id,
            'center'       => $this->center_id,
            'device'       => $this->whenLoaded('device') ? new DeviceResource($this->device):[],
            'num_nabadat'  => $this->num_nabadat,
            'nabada_price' => $this->nabada_price,
            'total_price'  => $this->total_price,
            'created_at'   => $this->created_at
        ];
    }
}
