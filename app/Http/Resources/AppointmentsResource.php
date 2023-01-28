<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentsResource extends JsonResource
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
           'day_key'=>$this->day_of_week,
           'day_text'=>$this->day_text,
           'from'=>Carbon::parse($this->from)->format('H:i a'),
           'to'=>Carbon::parse($this->to)->format('H:i a'),
       ];
    }
}
