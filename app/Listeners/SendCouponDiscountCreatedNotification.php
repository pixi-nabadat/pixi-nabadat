<?php

namespace App\Listeners;

use App\Events\PushEvent;
use App\Models\FcmMessage;
use App\Models\Order;
use App\Models\User;
use App\Services\PushNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCouponDiscountCreatedNotification
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
        if (is_null($event->type) or $event->type != FcmMessage::CREATE_NEW_COUPON_DISCOUNT)
            return ;
        $coupon = $event->model ;
        //prepare data
//        check if there is  an active fcm message for create order action
        $fcmMessage = FcmMessage::query()->where('is_active',true)->where('fcm_action',FcmMessage::CREATE_NEW_COUPON_DISCOUNT)->first();
        if (!$fcmMessage)
            return;

        $title = $fcmMessage->title ;
        $body = $fcmMessage->content ;
        $replaced_values = [];
        $body = replaceFlags($body,$replaced_values);
        $tokens = User::where('type',User::CUSTOMERTYPE)->pluck('device_token')->toArray();
        app()->make(PushNotificationService::class)->sendToTokens(title: $title,body: $body,tokens: $tokens);
    }
}
