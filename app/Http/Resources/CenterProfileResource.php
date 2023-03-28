<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CenterProfileResource extends JsonResource
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
            'token'=>$this->getToken(),
            'token_type'=>'Bearer',
            'user'=>[
                "id"=> $this->id,
                "name"=> $this->getTranslations('name'),
                "email"=> $this->email,
                "phone"=> $this->phone,
                "type"=> $this->type,
                "is_active"=> $this->is_active,
                "location_id"=> $this->location_id,
                "date_of_birth"=> $this->date_of_birth,
                "points"=> $this->points,
                "points_expire_date"=> $this->points_expire_date,
                "last_login"=> $this->last_login,
                "device_token"=> $this->device_token,
                "created_at"=> $this->created_at,
                "updated_at"=> $this->updated_at,
                'description'=>$this->whenLoaded('center', $this->center, "kj")
            ],
        ];
    }
}
