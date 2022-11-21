<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserPackagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
        'userPackage_id' => $this->id,
        'package_id' => $this->package_id,
        'user_id' => $this->user_id,
        'num_nabadat' => $this->num_nabadat,
        'price' => $this->price,
        ];
    }
}
