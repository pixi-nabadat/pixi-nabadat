<?php

namespace App\Listeners;

use App\Enum\UserPackageStatusEnum;
use App\Events\PushEvent;
use App\Models\FcmMessage;
use App\Models\Order;
use App\Services\PushNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendReservationStatusNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderCreated  $event
     * @return void
     */
    public function handle(PushEvent $event)
    {
        if (is_null($event->type) or $event->type != FcmMessage::CHANGE_RESERVATION_STATUS)
            return ;
//        check if there is  an active fcm message for create order action
        $fcmMessage = FcmMessage::query()->where('is_active',true)->where('fcm_action',FcmMessage::CHANGE_RESERVATION_STATUS)->first();
        if (!$fcmMessage)
            return;

        //prepare FCM data
        $reservationHistory = $event->model;
        $reservation = $reservationHistory->reservation;
        $user = $reservation->user;
        $center = $reservation->center;
        $user_name = $user->name ;
        $reservation_number = $reservation->id ;
        $reservation_status = $reservationHistory->status;
        $center_name = $center->user->name;

        $body = $fcmMessage->content ;
        $replaced_values = [
            '@USER_NAME@'   =>$user_name,
            '@RESERVATION_NUMBER@'=>$reservation_number,
            '@RESERVATION_STATUS@'=>$reservation_status,
            '@CENTER_NAME@'=>$center_name,
        ];

        $title = $fcmMessage->title ;

        $body = replaceFlags($body,$replaced_values);

        $token =[$user->device_token];

        $data = ['reservation_id' => $reservation->id];

        app()->make(PushNotificationService::class)->sendToTokens(title: $title,body: $body,tokens: $token,data: $data);
    }
}
