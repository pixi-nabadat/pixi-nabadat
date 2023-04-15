<?php

namespace App\Http\Resources;

use App\Enum\ImageTypeEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class CenterResource extends JsonResource
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
            'name' => $this->when($this->whenLoaded('user'), $this->user->name),
            'phones' => $this->phones,
            'location_title' => $this->whenLoaded('user',$this->user->location->title),
            'location_id' =>  $this->whenLoaded('user',$this->user->location_id),
            'description' => $this->description,
            'address' => $this->address,
            'rate' => $this->rate,
            'pulse_price' => $this->pulse_price,
            'pulse_discount' => $this->pulse_discount,
            'pulse_price_after_discount' => $this->pulsePriceAfterDiscount,
            'support_payments' => $this->support_payments,
            'avg_waiting_time' => $this->avg_waiting_time,
            'google_map_url' => $this->google_map_url,
            "doctors" => DoctorsResource::collection($this->whenLoaded('doctors')),
            'appointments' =>  AppointmentsResource::collection($this->whenLoaded('appointments')),
            'is_support_auto_service' => ($this->is_support_auto_service == 1),
            'images' => AttachmentsResource::collection($this->whenLoaded('attachments',$this->attachments->where('type', '!=', ImageTypeEnum::LOGO))),
            'logo' => $this->whenLoaded('user', $this->user->image),
            'feedback' => RatesResource::collection($this->whenLoaded('rates')),
            'devices' => DeviceResource::collection($this->whenLoaded('devices')),
            'packages' => PackagesResource::collection($this->whenLoaded('packages')),
        ];
    }
}
