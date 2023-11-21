<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use App\Services\PushNotificationService;

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
            app()->make(PushNotificationService::class)->sendToTokens(title: $title,body: $body,tokens: $tokens);

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
                '@EXPIRE_DATE@'=>$user->points_expire_date,
            ];
            $body = replaceFlags($body,$replaced_values);
            $tokens[0] = $user->device_token;
            app()->make(PushNotificationService::class)->sendToTokens(title: $title,body: $body,tokens: $tokens);

        }

    }
}