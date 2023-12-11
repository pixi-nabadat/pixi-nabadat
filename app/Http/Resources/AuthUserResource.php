<?php

namespace App\Http\Resources;

use App\Enum\ImageTypeEnum;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

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
        //    'token'=>$request->bearerToken()?? $this->getToken(),
           'token'=>$request->bearerToken()?? $this->token,
           'token_type'=>'Bearer',
           'user'=>[
            "id"=> $this->id,
            "name"=> $this->name,
            "email"=> $this->email,
            "phone"=> $this->phone,
            "type"=> $this->type,
            "is_active"=> $this->is_active,
            "location"=> $this->whenLoaded('location', new LocationsResource($this->location)),
            'profile_image' =>($this->whenLoaded('attachments') && isset($this->attachments))?new AttachmentsResource($this->attachments) : array('path'=>asset('assets/images/default-image.jpg')),
            "date_of_birth"=> $this->date_of_birth,
            "points"=> $this->points,
            "points_expire_date"=> $this->points_expire_date,
            "last_login"=> $this->last_login,
            "device_token"=> $this->device_token,
            "allow_push_notification"=>(bool) $this->allow_notification,
            "updated_at"=> $this->updated_at,
            "wallet"=>$this->whenLoaded('nabadatWallet',$this->nabadatWallet),
            'center'=> $this->whenLoaded('center', new UserCenterResource($this->center)),
        ],
       ];
    }

    public $additional =[
        'status'=>true,
        'message'=>'logged_in_successfully'
    ];
}
