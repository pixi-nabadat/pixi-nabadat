<?php

namespace App\Http\Resources;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class WeekDaysResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $date = \Carbon\Carbon::now(config('app.africa_timezone'));
       return [
           'id'=>array_search($this->resource,Appointment::WEEKDAYS),
           'day_text'=>$this->resource,
           'date'=>getDateOfSpecificDay(array_search($this->resource,Appointment::WEEKDAYS),$date)->format('F j, Y'),
       ];
    }
}
