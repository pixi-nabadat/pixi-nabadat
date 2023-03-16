<?php

namespace App\Http\Resources;

use App\Enum\ImageTypeEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class CenterDeviceResource extends JsonResource
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
            'id'                 => $this->id,
            'device_id'          => $this->device_id,
            'center_id'          => $this->center_id,
            'number_of_devices'  => $this->number_of_devices,
            'is_active'          => $this->is_active,
            'name'               => $this->whenLoaded('device',optional($this->device)->name),
            'description'        => $this->whenLoaded('device',optional($this->device)->description),
            'primary_image'      => $this->primary_image_path,
            'gallery'            =>  AttachmentsResource::collection($this->whenLoaded('attachments',$this->attachments->where('type',ImageTypeEnum::GALARY))),
        ];
    }
}
