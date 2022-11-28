<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartsResource extends JsonResource
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
            'user'          => $this->relationLoaded('user') ? new AuthUserResource($this->user) :null,
            'discount'      => $this->discount,
            'sub_total'     => $this->sub_total,
            'net_total'     => $this->net_total,
            'grand_total'   => $this->grand_total,
            'tax'           => $this->tax,
            'shipping_cost' => $this->shipping_cost,
            'temp_user_id'  => $this->temp_user_id,
            'address'       => $this->address_id
        ];
    }
}
