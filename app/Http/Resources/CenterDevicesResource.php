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
//            'center'=> $this->whenLoaded('center') ? new CenterResource($this->center):[],
            'device'=> $this->whenLoaded('device') ? new DeviceResource($this->device):[],
            'auto_service'=> $this->auto_service,
            'is_active'=>$this->is_active,
            'number_of_devices'=>$this->number_of_devices,
        ];
    }
}
