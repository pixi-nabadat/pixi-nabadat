<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SlidersResource extends JsonResource
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
            'order'      => $this->order,
            'center'     => $this->relationLoaded('center') ? new CenterResource($this->center): null,
            'duration'   => $this->duration,
            'start_date' => $this->start_date,
            'end_date'   => $this->end_date,
            'logo'       => $this->whenLoaded('defaultLogo',isset($this->defaultLogo)?asset($this->defaultLogo->path ."/".$this->defaultLogo->filename):null),
            'is_active'  => $this->is_active,
        ];
    }
}
