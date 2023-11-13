<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeSearchResource extends JsonResource
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
           'id'    =>$this->id,
           'title' =>$this->getTranslation('name', app()->getLocale()),
           'type'  => $this->search_flag,
           'type_text'  => $this->search_flag_text,
           'center_id'  => $this->whenLoaded('center', $this->center, null),
       ];
    }
}
