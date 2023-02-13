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
            'logo'       => $this->whenLoaded('attachments',isset($this->attachments)?asset($this->attachments->path ."/".$this->attachments->filename):null),
            'is_active'  => $this->is_active,
        ];
    }
}
