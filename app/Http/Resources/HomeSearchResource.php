<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HomeSearchResource extends JsonResource
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
           'products' => HomeSearchItemResource::collection($this->get(0)),
           'centers'  => HomeSearchItemResource::collection($this->get(1)),
           'devices'  => HomeSearchItemResource::collection($this->get(2)),
           'packages' => HomeSearchItemResource::collection($this->get(3)),
           'doctors'  => HomeSearchItemResource::collection($this->get(4)),
       ];
    }
}
