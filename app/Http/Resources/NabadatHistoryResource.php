<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NabadatHistoryResource extends JsonResource
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
            'device'       => $this->whenLoaded('device',new DeviceResource($this->device)),
            'num_nabadat'  => $this->num_nabadat,
            'auto_service' => $this->auto_service,
            'created_at'   => $this->created_at
        ];
    }
}