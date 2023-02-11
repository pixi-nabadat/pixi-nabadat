<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\User;

class NotificationService
{
    public function getUserNotifications($user_id)
    {
        $user = $this->getUser($user_id);
        return $user->notifications();
    }

    public function markAsRead($user_id, $notification_id): void
    {
        $user = $this->getUser($user_id);
        $user->notifications->where('id', $notification_id)->markAsRead();
    }
    public function notificationCount($user_id)
    {
        $user =  $this->getUser($user_id);
        return $user->notifications()->count();
    }

    public function getUser($user_id)
    {
        $user = User::find($user_id);
        if (!$user)
            throw new NotFoundException(trans('user_not_found'));
        return $user ;
    }
}
