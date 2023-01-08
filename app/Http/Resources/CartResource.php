<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'id'            => $this->id,
            'items_count'   => $this->items_count,
            'saved'         => $this->saved_amount,
            'discount'      => $this->coupon_discount,
            'sub_total'     => (double)$this->sub_total,
            'net_total'     => (double)$this->net_total,
            'grand_total'   => (double)$this->grand_total, // after applying all discounts
            'address_id'    => $this->address_id,
            'address_info'  => $this->relationLoaded('address') ? $this->address_id : null,
            'tax'           => (double)$this->tax,
            'shipping_cost' => (double)$this->shipping_cost,
            'items'         => $this->relationLoaded('items') ? CartItemsResource::collection($this->items) : [],
        ];
    }
}
