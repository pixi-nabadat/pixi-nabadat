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
            'id'                => $this->id,
            'product_id'        => $this->product_id,
            'name'              => $this->product->name,
            'quantity'          => $this->quantity,
            'price_before'      => $this->product->unit_price,
            'price_after'       => $this->price_after_discount,
            'discount'          => $this->product->product_discount,
            'total_price'       => $this->quantity * $this->price_after_discount,
            'image'             => $this->product->image_path,
            'points'             => changePoundsToPoints(money: $this->price_after_discount*$this->quantity),
        ];
    }
}
