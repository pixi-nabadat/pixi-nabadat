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
            'address_id' => $this->id,
            'address' => $this->address,
            'country' => $this->relationLoaded('location') ? new LocationsResource($this->country_id):null,
            'governerate_id' => $this->governerate_id,
            'city_id' => $this->city_id,
            'phone' => $this->phone,
            'postal_code' => $this->postal_code,
            'is_default' => $this->is_default,
            'lat' => $this->lat,
            'lng' => $this->lang,
       ];
    }
}
