<?php

namespace App\Services;


use App\Exceptions\NotFoundException;
use App\Models\User;
use Illuminate\Support\Arr;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class PushNotificationService extends BaseService
{

    public function __construct(protected UserService $userService)
    {
    }

//    public function sendFcm(array $data = []): array
//    {
//        $filters = ['type' => User::CUSTOMERTYPE];
//        if (!Arr::has($data['users'], 'all'))
//            $filters['users'] = $data['users'];
//        if (!Arr::has($data['locations'], 'all'))
//            $filters['locations'] = $data['locations'];
//        if (!Arr::has($data['centers'], 'all'))
//            $filters['where_has_reservation'] = $data['centers'];
//        $users = app()->make(UserService::class)->getAll($filters);
//        $device_tokens = $users->pluck('device_token');
//        return array_filter($device_tokens);
//    } //end of store


    public function getUserNotifications()
    {
        $user = $this->userService->getAuthUser();
        return $user->notifications()->orderByDesc('id')->get();
    }

    public function unReadCount($auth_user_id)
    {
        $user = $this->userService->getAuthUser();
        return $user->notifications()->whereNull('read_at')->count();
    }

    public function markAsRead($notification_id)
    {
        $user =$this->userService->getAuthUser();
        $user->notifications()->where('id', $notification_id)->markAsRead();
    }


    public function sendToTokens(string $title, string $body,$tokens = [],$data = [])
    {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($data);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();

// return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

// return Array (key : oldToken, value : new token - you must change the token in your database)
        $downstreamResponse->tokensToModify();

// return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();

// return Array (key:token, value:error) - in production you should remove from your database the tokens
        $downstreamResponse->tokensWithError();
    }

}