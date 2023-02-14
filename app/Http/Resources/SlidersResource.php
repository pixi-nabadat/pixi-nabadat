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
            'center'     => $this->center_id,
            'duration'   => $this->duration,
            'image'      => isset($this->logo)?asset($this->logo->path ."/".$this->logo->filename):asset('assets/images/default-image.jpg'),
        ];
    }
}
