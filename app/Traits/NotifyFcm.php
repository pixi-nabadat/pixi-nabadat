<?php

namespace App\Traits;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
trait NotifyFcm
{

    private function _build_notification($title, $message, $data)
    {
        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder
            ->setTitle($title)
            ->setBody($message)
            ->setSound('default');

        $optionBuilder = new OptionsBuilder();
        $dataBuilder = new PayloadDataBuilder();

        $dataBuilder->addData($data);

        return [$notificationBuilder->build(), $dataBuilder->build(), $optionBuilder->build()];
    }

    public function sendToToken($tokens, $title, $message, $data = [])
    {
        list($notification, $data, $option) = $this->_build_notification($title, $message, $data);
        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
        logger("numberSuccess = " . $downstreamResponse->numberSuccess());
        logger("numberFailure = " . $downstreamResponse->numberFailure());
    }

}
