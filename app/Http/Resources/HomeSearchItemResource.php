<?php

namespace App\Http\Resources;

use App\Enum\ImageTypeEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeSearchItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        switch($this->search_flag)
        {
            case 1:
                $logo = $this->image_path;
                break;
            case 2:
                $logo = $this->image_path;
                break;
            case 3:
                $logo = $this->attachments->where('type', ImageTypeEnum::LOGO)->first();
                $logo = isset($logo) ? asset($logo->path."/".$logo->filename):asset('assets/images/default-image.jpg');
                break;
            case 4:
                $logo = $this->image_path;
                break;
            case 5:
                $logo = $this->image_path;
                break;
            default: 
                $logo = asset('assets/images/default-image.jpg');
        }
       return [
           'id'    =>$this->id,
           'title' =>$this->getTranslation('name', app()->getLocale()),
           'type'  => $this->search_flag,
           'type_text'  => $this->search_flag_text,
           'logo'=> $logo,
           'center_id'  => $this->whenLoaded('center', $this->search_flag == 3 ? $this->center : [$this->center], null),
       ];
    }
}
