<?php

namespace App\Notifications;

use Benwilkins\FCM\FcmMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FcmNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['fcm'];
    }

    public function toFcm($notifiable)
    {
        $message = new FcmMessage();
        $message->content([
            'title' => 'Foo',
            'body' => 'Bar',
            'sound' => '', // Optional
            'icon' => '', // Optional
            'click_action' => '' // Optional
        ])->data([
            'param1' => 'baz' // Optional
        ]); // Optional - Default is 'normal'.

        return $message;
    }
}
