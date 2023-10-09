<?php

namespace App\Http\Resources;

use App\Enum\ImageTypeEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCenterResource extends JsonResource
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
            'id' => $this->id,
            "name"=> $this->name,
            "name_translatable"=> $this->getTranslations('name'),
            'phones' => $this->phones,
            'description' => $this->description,
            'address' => $this->address,
            'pulse_price' => $this->pulse_price,
            'support_payments' => $this->support_payments,
            'avg_waiting_time' => $this->avg_waiting_time,
            'google_map_url' => $this->google_map_url,
            'is_support_auto_service' => ($this->is_support_auto_service == 1),
            'logo' => new AttachmentsResource($this->attachments->where('type', ImageTypeEnum::LOGO)->first()),
            'images' => AttachmentsResource::collection($this->attachments->where('type', ImageTypeEnum::GALARY)),
        ];
    }
}
