<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentsResource extends JsonResource
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
           'id' =>$this?->id,
           'path'=> isset($this?->path) ? asset($this->path."/".$this->filename) : asset('assets/images/default-image.jpg'),
       ];
    }
}
