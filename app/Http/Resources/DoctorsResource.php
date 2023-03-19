<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorsResource extends JsonResource
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
            'name_translations' => $this->getTranslations('name'),
            'phone' => $this->phone,
            'description' => $this->description,
            'description_translations' => $this->getTranslations('description'),
            'image' => $this->image_path,
            'is_active' => $this->is_active,
        ];
    }
}
