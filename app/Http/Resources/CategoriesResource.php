<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $attachment = $this->whenLoaded('attachments') ? $this->attachments->first():null;
       return [
           'name'=>$this->name,
           'image'=>isset($attachment) ? url($attachment->path."/".$attachment->filename):null,

       ];
    }
}
