<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorsResource extends JsonResource
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
            'id'            => $this->id,
            'name_ar'       => $this->getTranslation('name', 'ar'),
            'name_en'       => $this->getTranslation('name', 'en'),
            'phone'         => $this->phone,
            'description_ar'       => $this->getTranslation('description', 'ar'),
            'description_en'       => $this->getTranslation('description', 'en'),
            'image'         => $this->when(($this->relationLoaded('defaultLogo')&&!empty($this->defaultLogo)),asset(optional($this->defaultLogo)->path."/".optional($this->defaultLogo)->filename),asset('assets/images/default-image.jpg')),
            'is_active'     => $this->is_active,
        ];
    }
}
