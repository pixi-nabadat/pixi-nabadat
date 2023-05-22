<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PhoneVerifyRequest;
use App\Models\FcmMessage;
use App\Models\ResetCodePassword;
use Illuminate\Http\Request;

class PhoneVerifyController extends Controller
{
    public function __invoke(PhoneVerifyRequest $request)
    {
        ResetCodePassword::where('phone', $request->phone)->delete();
        // Create a new code
        $codeData = ResetCodePassword::create($request->data());
        //Todo send sms or slack notification with code
        //logic code of sending code here

         if ($codeData)
        {
            $title = 'Your OTP Code';
            $body = $codeData;
            $tokens = $request->token->toArray();
            app()->make(PushNotificationService::class)->sendToTokens(title: $title,body: $body,tokens: $tokens);
        }
    }
}
