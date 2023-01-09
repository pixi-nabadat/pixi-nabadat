<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthUserResource extends JsonResource
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
           'id'            => $this->id,
           'name'          => $this->name,
           'user_name'     => $this->user_name,
           'phone'         => $this->phone,
           'date_of_birth' => $this->date_of_birth,
           'referal_code'  => $this->referal_code,
       ];
    }
}
