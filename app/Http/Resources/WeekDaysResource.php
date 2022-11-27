<?php

namespace App\Http\Resources;

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
        $date = Carbon::now()->timezone('Africa/Cairo');
       return [
           'id'=>$this->resource['day_of_week'],
           'day_text'=>Arr::except($this->resource, ['day_of_week']),
//           'date' => getDateOfSpecificDay($this->resource['day_of_week'],$date)
       ];
    }
}
