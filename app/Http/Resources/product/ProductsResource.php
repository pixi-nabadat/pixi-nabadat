<?php

namespace App\Http\Resources\product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->unit_price,
            'discount' => $this->discount,
            'description' => $this->description,
            'rate' => $this->rate,
            'price_after_discount' => getPriceAfterDiscount($this->unit_price, $this->product_discount),
            'image' => ['path' => $this->image_path],
        ];
    }
}
