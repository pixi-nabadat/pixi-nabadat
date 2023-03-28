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
                'center'=>$this->whenLoaded('center', 
                [
                    'id'=>$this->center->id,
                    'phones'=>$this->center->phones,
                    'description'=>$this->center->getTranslations('description'),
                    'address'=>$this->center->getTranslations('address'),
                    'lat'=>$this->center->lat,
                    'lng'=>$this->center->lng,
                    'featured'=>$this->center->featured,
                    'avg_waiting_time'=>$this->Center->avg_waiting_time,
                    'is_support_auto_service'=>$this->center->is_support_auto_service,
                    'google_map_url'=>$this->center->google_map_url,
                    'rate'=>$this->center->rate,
                    'pulse_price'=>$this->center->pulse_price,
                    'support_payments'=>$this->center->support_payments,
                    'created_at'=>$this->center->created_at,
                    'update_at'=>$this->center->updated_at,
                ])
            ],
        ];
    }
}
