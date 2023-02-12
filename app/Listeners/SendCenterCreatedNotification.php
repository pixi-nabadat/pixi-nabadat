<?php

namespace App\Listeners;

use App\Events\PushEvent;
use App\Models\FcmMessage;
use App\Models\Order;
use App\Models\User;
use App\Services\PushNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCenterCreatedNotification
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
        if (is_null($event->type) or $event->type != FcmMessage::DEAL_WITH_NEW_CENTER)
            return ;

//      check if there is  an active fcm message for create order action
        $fcmMessage = FcmMessage::query()->where('is_active',true)->where('fcm_action',FcmMessage::DEAL_WITH_NEW_CENTER)->first();
        if (!$fcmMessage)
            return;

        //prepare data
        $center = $event->model ;
        $center_user = $center->user;
        $location_name = $center_user->location->title ;
        $center_name = $center_user->name;

        $title = $fcmMessage->title ;
        $body = $fcmMessage->content ;
        $replaced_values = [
            '@CENTER_LOCATION@'=>$location_name,
            '@CENTER_NAME@'=>$center_name,
        ];
        $body = replaceFlags($body,$replaced_values);
        $tokens = User::where('type',User::CUSTOMERTYPE)->pluck('device_token')->toArray();
        app()->make(PushNotificationService::class)->sendToTokens(title: $title,body: $body,tokens: $tokens);
    }
}
