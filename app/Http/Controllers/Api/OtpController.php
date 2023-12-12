<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SmsRequest;
use App\Models\ResetCodePassword;
use App\Services\SmsService;

class OtpController extends Controller
{
    public function __invoke(SmsRequest $request)
    {
        ResetCodePassword::sendCode(phone: $request->phone);
        return apiResponse(trans('lang.success_operation'));
    }
}
