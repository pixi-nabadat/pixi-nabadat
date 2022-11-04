<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GetListDoctortResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data =  [
            'doctor_id' => $this->id,
            'doctor_name' => $this->name,
            'doctor_phone' => $this->phone,
            'description' => $this->description,
        ];
        $photopath = fileDir('doctor');
        $data['doctor_photo'] = $photopath . $this->photo ?? NULL;
        return $data;
    }
}
