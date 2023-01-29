<?php

namespace App\Listeners;

use App\Events\PushEvent;
use App\Models\FcmMessage;
use App\Models\Order;
use App\Services\PushNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendChangeOrderStatusNotification
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
        if (is_null($event->type) or $event->type != FcmMessage::CHANGE_ORDER_STATUS)
            return ;
        $order = $event->order ;
        //prepare data
        $user_name = $order->user->name ;
        $order_id = $order->id ;
        $order_status = trans('lang.pending');
//        check if there is  an active fcm message for create order action
        $fcmMessage = FcmMessage::query()->where('is_active',true)->where('fcm_action',FcmMessage::CHANGE_ORDER_STATUS)->first();
        if (!$fcmMessage)
            return;

        $title = $fcmMessage->title ;
        $body = $fcmMessage->content ;
        $replaced_values = [
            '@USER_NAME@'   =>$user_name,
            '@ORDER_NUMBER@'=>$order_id,
            '@ORDER_STATUS@'=>$order_status
        ];
        $body = replaceFlags($body,$replaced_values);
        $token =[$order->user->device_token];
        $data = ['order_id' => $order_id];
        app()->make(PushNotificationService::class)->sendToTokens(title: $title,body: $body,tokens: $token,data: $data);
    }
}
