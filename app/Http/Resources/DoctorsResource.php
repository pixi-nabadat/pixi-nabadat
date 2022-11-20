<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       return  [
            'doctor_id'     => $this->id,
            'doctor_name'   => $this->name,
            'doctor_phone'  => $this->phone,
            'description'   => $this->description,
            'image'         => $this->whenLoaded('attachments') ? new AttachmentsResource($this->attachments->first()) : null
       ];
    }
}
