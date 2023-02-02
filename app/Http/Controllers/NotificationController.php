<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationsResource;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(protected NotificationService $notificationService)
    {
    }

    public function index()
    {
        $user_id = auth()->id();
        $notifications = $this->notificationService->getUserNotifications($user_id);
        return NotificationsResource::collection($notifications);
    }
}
