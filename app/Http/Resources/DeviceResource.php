<?php

namespace App\Http\Resources;

use App\Enum\ImageTypeEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
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
            'id'            => $this->id,
            'name'          => $this->name,
            'description'   => $this->description,
            'logo'          => $this->whenLoaded('attachments',  new AttachmentsResource($this->attachments->where('type',ImageTypeEnum::LOGO)->first())),
            'images'        => $this->whenLoaded('attachments', AttachmentsResource::collection($this->attachments->where('type',ImageTypeEnum::GALARY))),
        ];
    }
}
