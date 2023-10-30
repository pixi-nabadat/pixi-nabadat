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
            'order'         => $this->order,
            'sliderable_id' => $this->sliderable_id,
            'start_date'    => $this->start_date,
            'end_date'      => $this->end_date,
            'image'         => $this->image_path,
            'type'          => $this->type,
        ];
    }
}
