<?php

namespace App\Http\Resources;

use App\Enum\ImageTypeEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class PackagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $default_image = ['path'=>asset('assets/images/default-image.jpg')] ;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'num_nabadat' => $this->num_nabadat,
            'price' => $this->price,
            'price_after_discount' => getPriceAfterDiscount(price: $this->price, discountValue: $this->discount_percentage ?? 0),
            'image'=> isset($this->attachments) ? new AttachmentsResource($this->attachments):$default_image,
            'center' => new CentersResource($this->whenLoaded('center')),
        ];
    }
}
