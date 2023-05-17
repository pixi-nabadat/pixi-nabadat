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
        $logo = $this->attachments->where('type', ImageTypeEnum::LOGO)->first();
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'description'   => $this->description,
            'logo'          => isset($logo) ? asset($logo->path."/".$logo->filename):asset('assets/images/default-image.jpg'),
            'images'        => $this->whenLoaded('attachments', AttachmentsResource::collection($this->attachments->where('type',ImageTypeEnum::GALARY))),
        ];
    }
}
