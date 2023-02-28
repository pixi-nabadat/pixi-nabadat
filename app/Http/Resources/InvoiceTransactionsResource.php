<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceTransactionsResource extends JsonResource
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
            'id'=>$this->id,
            'num_pulses'=> $this->num_pulses,
            'center_dues'=>$this->center_duses,
            'nabadat_app_dues'=>$this->nabadat_app_dues,
            'original_price'=>$this->original_price,
            'center_discount'=>$this->center_discount,
            'user_discount'=>$this->user_discount,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'user'=> $this->whenLoaded('user',[
                'id'=>$this->user->id,
                'name'=>$this->user->name,
                'phone'=>$this->user->phone,
            ]),
            
        ];
    }
}
