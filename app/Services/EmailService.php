<?php

namespace App\Services;

use App\Mail\NotificationMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EmailService extends BaseService
{

    public function __construct()
    {
    }

    public function sendEmailNotification(User $user, string $message)
    {   	

        Mail::to($user)->send(new NotificationMail($message));
        // Process the response
        return true;
    }

}