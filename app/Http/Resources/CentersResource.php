<?php

namespace App\Http\Resources;

use App\Enum\ImageTypeEnum;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Center;
class CentersResource extends JsonResource
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
            'id'                            => $this->id,
            'name'                          => $this->whenLoaded('user',$this->user->name),
            'description'                   => $this->description,
            'address'                       => $this->address,
            'logo'                          => $this->whenLoaded('defaultLogo',isset($this->defaultLogo)?asset($this->defaultLogo->path ."/".$this->defaultLogo->filename):null),
            'rate'                          => $this->rate
            ];
    }
}
