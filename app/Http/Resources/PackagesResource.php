<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackagesResource extends JsonResource
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
        'id'            =>$this->id,
        'name'          =>$this->name,
        'num_nabadat'   =>$this->num_nabadat,
        'price'         =>$this->price,
        'price_after_discount'  =>getPriceAfterDiscount(price: $this->price,discountValue: $this->discount_percentage),
        'is_active'     =>$this->is_active,
        'image'         =>$this->when(($this->whenLoaded('attachments')&&isset($this->attachments)),asset(optional($this->attachments)->path . "/" . optional($this->attachments)->filename),asset('assets/images/default-image.jpg')),
        'center'        =>new CentersResource($this->whenLoaded('center')),
       ];
    }
}
