<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationsResource extends JsonResource
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
           'id'=>$this->id,
           'title'=>$this->reason,
           'body'=>$this->reason,
           'url'=>$this->reason,
           'image'=>$this->reason,
           'is_readed'=>$this->reason,
       ];
    }
}
