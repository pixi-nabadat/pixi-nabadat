<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CodeCheckRequest;
use App\Models\ResetCodePassword;
use Illuminate\Http\Request;

class CodeCheckController extends Controller
{
    public function __invoke(CodeCheckRequest $request)
    {
        $passwordReset = ResetCodePassword::firstWhere('code', $request->code);

        if ($passwordReset->isExpire())
            return apiResponse(message:__('lang.code_is_expire'),code: 422);
        return apiResponse(data:$passwordReset->code,message:__('lang.code_is_valid'));
    }
}
