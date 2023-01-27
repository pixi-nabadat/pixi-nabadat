<?php

namespace App\Services;

use App\Enum\ImageTypeEnum;
use App\Exceptions\NotFoundException;
use App\Models\Doctor;
use App\Models\FcmMessage;
use App\QueryFilters\DoctorsFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\BadRequestHttpException;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\DoctorsResource;

class FcmMessageService extends BaseService
{
    public function store(array $data = [])
    {
        $data['is_active'] = isset($data['is_active'])  ? 1 :  0;
        $fcm_message = FcmMessage::create($data);
        if (!$fcm_message)
           throw new BadRequestHttpException(trans('lang.there_is_an_error'),400);
        return $fcm_message;
    } //end of store

    public function update(int $id, array $data=[])
    {
        $fcmMessage = $this->find($id);
        $data['is_active'] = isset($data['is_active'])  ? 1 :  0;
        return $fcmMessage->update($data);
    }

    public function find(int $fcm_message_id )
    {
        $fcm_message =  FcmMessage::find($fcm_message_id);
        if (!$fcm_message)
            throw new NotFoundException(trans('lang.fcm message not found'),404);
        return $fcm_message;
    }

    public function delete($id)
    {
        $fcm_message = $this->find($id);
        return $fcm_message->delete();
    } //end of delete

    public function status($id)
    {
        $fcm_message = $this->find($id);
        $fcm_message->is_active = !$fcm_message->is_active;
        return $fcm_message->save();

    }//end of status

}
