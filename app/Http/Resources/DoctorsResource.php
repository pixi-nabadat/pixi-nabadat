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
            'id'            => $this->id,
            'name'          => $this->name,
            'phone'         => $this->phone,
            'description'   => $this->description,
            'image'         => $this->whenLoaded('defaultLogo',isset($this->defaultLogo) ?asset($this->defaultLogo->path."/".$this->defaultLogo->filename):null),
            'is_active'     => $this->is_active,
        ];
    }
}
