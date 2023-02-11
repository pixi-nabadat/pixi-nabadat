<?php

namespace App\Http\Resources;

use App\Enum\ImageTypeEnum;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Center;
class CenterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $logo = $this->attachments->where('type',ImageTypeEnum::LOGO)->first() ;
        return [
            'id'                            => $this->id,
            'name'                          => $this->whenLoaded('user',$this->user->name),
            'phones'                        => $this->phones,
            'location_title'                => $this->whenLoaded('user',$this->user->location->title),
            'location_id'                   => $this->whenLoaded('user',$this->user->location_id),
            'description'                   => $this->description,
            'address'                       => $this->address,
            'rate'                          => $this->rate ,
            'lat'                           => $this->lat ,
            'lng'                           => $this->lng,
            'pulse_price'                   => $this->pulse_price,
            'pulse_discount'                => $this->pulse_discount,
            'app_discount'                  => $this->app_discount,
            'support_payments'              => $this->support_payments,
            'avg_waiting_time'              => $this->avg_waiting_time,
            'google_map_url'                => $this->google_map_url,
            "doctors"                       => $this->whenLoaded('doctors',DoctorsResource::collection($this->doctors)),
            'appointments'                  => $this->whenLoaded('appointments',AppointmentsResource::collection($this->appointments)),
            'is_support_auto_service'       => ($this->is_support_auto_service == 1),
            'images'                        => $this->whenLoaded('attachments', AttachmentsResource::collection($this->attachments->where('type','!=',ImageTypeEnum::LOGO))),
            'logo'                          => $this->whenLoaded('attachments', isset($logo) ? url($logo->path.'/'.$logo->filename) : null),
            'feedback'                      =>$this->whenLoaded('rates',RatesResource::collection($this->rates)),
        ];
    }
}
