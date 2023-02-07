<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CenterDevicesResource extends JsonResource
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
            'center'=> $this->whenLoaded('center') ? new CenterResource($this->center):[],
            'device'=> $this->whenLoaded('device') ? new DeviceResource($this->device):[],
            'regular_price'=> $this->regular_price,
            'auto_service_price'=>$this->auto_service_rice,
            'number_of_devices'=>$this->number_of_devices,
        ];
    }
}
