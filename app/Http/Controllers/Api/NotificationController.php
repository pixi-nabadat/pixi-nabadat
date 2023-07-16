<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationMarkAsReadRequest;
use App\Http\Resources\NotifcationsResource;
use App\Services\PushNotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(protected PushNotificationService $pushNotificationService)
    {
    }

    public function getNotifications()
    {
        try {
            $notifications = $this->pushNotificationService->getUserNotifications();
            return NotifcationsResource::collection($notifications);
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 400);
        }
    }

    public function markAsRead(NotificationMarkAsReadRequest $request)
    {
        try {
            $this->pushNotificationService->markAsRead($request->id);
            return apiResponse();
        } catch (\Exception $exception) {
            return apiResponse(message: 'there is an error', code: 400);
        }
    }


    //    send fcm to token
    public function sendFcmToToken(Request $request)
    {
        try {
            $title = $request->title;
            $body = $request->body;
            $tokens = $request->device_tokens;
            app()->make(PushNotificationService::class)->sendToTokens(title: $title,body: $body,tokens: $tokens);
            return apiResponse(message: trans('lang.success_operation'));
        } catch (\Exception $exception) {
            return apiResponse(message: $exception->getMessage(), code: 400);
        }
    }
}
