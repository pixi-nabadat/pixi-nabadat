<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NotifcationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $lang = getLocale();
       return [
           'id'=>$this->data['model_id'],
           'type'=>$this->data['type'],
           'title'=>$this->data['title']["$lang"]??null,
           'message'=>$this->data['message']["$lang"]??null,
           'created_at'=>Carbon::parse($this->created_at)->diffForHumans()
           ];
    }

}
