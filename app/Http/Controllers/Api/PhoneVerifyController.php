<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PhoneVerifyRequest;
use App\Http\Resources\AuthUserResource;
use App\Models\ResetCodePassword;
use App\Models\User;
use App\Services\SmsService;

class PhoneVerifyController extends Controller
{
    public function __invoke(PhoneVerifyRequest $request)
    {
        $passwordReset = ResetCodePassword::firstWhere('code', $request->code);
        if ($passwordReset->isExpire())
            return apiResponse(message:__('lang.code_is_expire'),code: 422);

        $user = User::firstWhere('phone', $passwordReset->phone);

        $user->update(['is_active'=>1]);

        $passwordReset->delete();

        return new AuthUserResource($user);
    }
}
