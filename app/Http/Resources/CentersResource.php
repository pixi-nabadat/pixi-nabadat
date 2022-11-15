<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Center;
class CentersResource extends JsonResource
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
            'center_id'      => $this->id,
            'center_name'    => $this->name,
            'center_phone'   => $this->phone,
            'location'       => $this->location->title,
            'description'    => $this->description,
            'address'        => $this->address,
            'lat'            => $this->lat ,
            'lng'            => $this->lng,
            'google_map_url' => $this->google_map_url,
            'is_active'      => ($this->is_active == 1),
            "doctors"        => DoctorsResource::collection($this->doctors),
            'is_support_auto_service' => ($this->is_support_auto_service == 1),
            'images'         => $this->whenLoaded('attachments') ? AttachmentsResource::collection($this->attachments) : []
        ];
    }
}
