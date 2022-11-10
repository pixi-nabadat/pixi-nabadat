<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Center;
class GetListCenterResource extends JsonResource
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
            'center_id'      => $this->id,
            'center_name'    => $this->name ?? NULL,
            'center_phone'   => $this->phone ?? NULL,
            'location'       => $this->Location->title ?? NULL,
            'description'    => $this->description ??'',
            'address'        => $this->address ?? NULL,
            'lat'            => $this->lat ?? NULL,
            'lng'            => $this->lng ?? NULL,
            'google_map_url' => $this->google_map_url ?? NULL,
            'is_active'      => ($this->is_active == 1) ? Center::ACTIVE : Center::NON_ACTIVE,
            "doctors"        => GetListDoctortResource::collection($this->doctors),
            'is_support_auto_service' => ($this->is_support_auto_service == 1) ? Center::SUPPORT_AUTO_SERVICE : Center::NON_SUPPORT_AUTO_SERVICE,
        ];
    }
}
