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
            'image'=>$this->whenLoaded('defaultLogo',url(optional($this->defaultLogo)->path."\\".optional($this->defaultLogo)->filename)),
            'quantity'=>$this->quantity,
            'price'=>$this->price,
            'discount'=>$this->discount,
            'total_price'=>$this->quantity * $this->price,
            'total_price_after_discount' => $this->quantity * ($this->price - ($this->price * ($this->discount/100)))
        ];
    }
}
