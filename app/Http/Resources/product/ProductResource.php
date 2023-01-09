<?php

namespace App\Http\Resources\product;

use App\Http\Resources\AttachmentsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id'                        =>$this->id,
            'name'                      =>$this->name,
            'price'                     =>$this->unit_price,
            'discount'                  =>$this->discount,
            'description'               =>$this->description,
            'rate'                      =>$this->whenLoaded('rates',$this->rates),
            'price_after_discount'      =>getPriceAfterDiscount($this->unit_price,$this->product_discount),
            'image'=> $this->whenLoaded('attachments',AttachmentsResource::collection($this->attachments)),
        ];
    }
}
