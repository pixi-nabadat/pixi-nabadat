<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\NotifcationsResource;
use App\Services\PushNotificationService;


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

    public function markAsRead($id)
    {
        try {
            $this->pushNotificationService->markAsRead($id);
        } catch (\Exception $exception) {
            return apiResponse(message: 'there is an error', code: 400);
        }
    }

//    send fcm to token
}
