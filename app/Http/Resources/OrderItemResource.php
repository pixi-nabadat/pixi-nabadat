<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'name'=>$this->product->name,
            'image'=>$this->whenLoaded('defaultLogo',url($this->defaultLogo->path."\\".$this->defaultLogo->filename)),
            'quantity'=>$this->quantity,
            'price'=>$this->price,
            'total_price'=>$this->quantity*$this->price,
            'total_price_after_discount' => $this->quantity * getPriceAfterDiscount($this->price,$this->discount)
        ];
    }
}
