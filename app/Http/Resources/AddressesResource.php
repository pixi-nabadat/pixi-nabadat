<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressesResource extends JsonResource
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
            'id' => $this->id,
            'address' => $this->address,
            'governorate_id' => $this->governerate_id,
            'governorate_title' => $this->whenLoaded('governorate',$this->governorate->title),
            'city_id' => $this->city_id,
            'city_title' => $this->whenLoaded('city',$this->city->title),
            'shipping_fees' => $this->whenLoaded('city',$this->city->shipping_cost),
            'phone' => $this->phone,
            'postal_code' => $this->postal_code,
            'is_default' => $this->is_default,
            'lat' => $this->lat,
            'lng' => $this->lang,
       ];
    }
}
