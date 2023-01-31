<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackagesResource extends JsonResource
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
        'name'=>$this->name,
        'num_nabadat'=>$this->num_nabadat,
        'price'=>$this->price,
        'is_active'=>$this->is_active,
        'center'=>$this->whenLoaded('center',[
            'id'=>$this->center->id,
            'support_payments'=>$this->center->support_payments,
            'name'=>$this->center->name,
            'address'=>$this->center->address
        ]),
       ];
    }
}
