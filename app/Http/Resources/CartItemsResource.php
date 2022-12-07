<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItemsResource extends JsonResource
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
            'id'    => $this->id,
            'product'   => $this->product_id,
            'name'      => $this->product->name,
            'quantity'  => $this->quantity,
            'price_before'     => $this->price,
            'price_after'     => getPriceAfterDiscount($this->price,$this->product->discount,$this->product->discount_type),
            'discount'  => $this->product->discount . $this->product->discount_type == 0 ?' L.E':' %',
        ];
    }
}
