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
            'id'            => $this->device_id,
            'name'          => $this->device->name,
            'description'   => $this->device->description,
            'primary_image' => $this->whenLoaded('attachments', $this->attachments->where('type', ImageTypeEnum::LOGO)->first() !== null ? new AttachmentsResource($this->attachments->where('type',ImageTypeEnum::LOGO)->first()):asset('assets/images/default-image.jpg')),
            'gallery'       => $this->whenLoaded('attachments', AttachmentsResource::collection($this->attachments->where('type',ImageTypeEnum::GALARY))),

        ];
    }
}
