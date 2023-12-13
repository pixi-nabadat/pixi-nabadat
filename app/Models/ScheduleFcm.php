<?php

namespace App\Models;

use App\Enum\FcmEventsNames;
use App\Services\EmailService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Services\PushNotificationService;
use App\Services\SmsService;

class ScheduleFcm extends Model
{
    use HasFactory, Filterable;
    protected $fillable = [
        'title', 'content', 'trigger', 'notification_via', 'is_active',
    ];

    public static function ReservationCheckDateReminderFcm(ScheduleFcm $scheduleFcm, $reservations = [])
    {

        //prepare data
        $title = $scheduleFcm->title ;
        $body = $scheduleFcm->content ;
        foreach($reservations as $reservation)
        {
            $replaced_values = [
                '@USER_NAME@'=>$reservation->user->name,
                '@EXPIRE_DATE@'=>$reservation->check_date,
                '@RESERVATION_NUMBER@'=>$reservation->id,
                '@RESERVATION_STATUS@'=> $reservation->latestStatus,
                '@CENTER_NAME@'=>$reservation->center->user->name,
                '@CENTER_LOCATION@'=>$reservation->center->user->location->title,
            ];
            $body = replaceFlags($body,$replaced_values);
            // $tokens = $usersToken->toArray();
            $tokens[0] = $reservation->user->device_token;
            // app()->make(PushNotificationService::class)->sendToTokens(title: $title,body: $body,tokens: $tokens);
            if($scheduleFcm->notification_via == FcmEventsNames::$CHANNELS['fcm'])
                app()->make(PushNotificationService::class)->sendToTokens(title: $title,body: $body,tokens: $tokens);
            else if($scheduleFcm->notification_via == FcmEventsNames::$CHANNELS['sms'])
                app()->make(SmsService::class)->sendSMS(phones: $reservation->user->phone, message: $body);
            else
                $reservation->user->notify(new \App\Notifications\SendEmailNotification(message: $body));
        }

    }

    public static function UserReminderFcm(ScheduleFcm $scheduleFcm, $users)
    {

        //prepare data
        $title = $scheduleFcm->title ;
        $body = $scheduleFcm->content ;
        foreach($users as $user)
        {
            $replaced_values = [
                '@USER_NAME@'=>$user->name,
            ];
            $body = replaceFlags($body,$replaced_values);
            $tokens[0] = $user->device_token;
            app()->make(PushNotificationService::class)->sendToTokens(title: $title,body: $body,tokens: $tokens);

        }

    }

    public static function sendNotification($users, ScheduleFcm $scheduleFcm)
    {
        // $title = $scheduleFcm->title ;
        $body = $scheduleFcm->content ;
        foreach($users as $user)
        {
            $replaced_values = [
                '@USER_NAME@'=>$user->name,
            ];
            $body = replaceFlags($body,$replaced_values);
            $tokens[0] = $user->device_token;
            if($scheduleFcm->notification_via == FcmEventsNames::$CHANNELS['fcm'])
                ScheduleFcm::UserReminderFcm($scheduleFcm, $user);
            else if($scheduleFcm->notification_via == FcmEventsNames::$CHANNELS['sms'])
                app()->make(SmsService::class)->sendSMS(phones: $user->phone, message: $body);
            else
                $user->notify(new \App\Notifications\SendEmailNotification(message: $body));
        }
    }
}