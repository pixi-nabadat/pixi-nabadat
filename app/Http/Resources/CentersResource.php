<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CentersResource extends JsonResource
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
            'name' => $this->whenLoaded('user', $this->user->name),
            'description' => $this->description,
            'address' => $this->address,
            'logo' => $this->when(($this->whenLoaded('defaultLogo')&&isset($this->defaultLogo)),asset(optional($this->defaultLogo)->path . "/" . optional($this->defaultLogo)->filename),'') ?  : asset('assets/images/default-image.jpg'),
            'rate' => $this->rate
        ];
    }
}
