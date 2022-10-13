<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\ResetCodePassword;
use App\Models\User;

class RestPasswordController extends Controller
{
    /**
     * Change the password
     *
     * @param  mixed $request
     */
    public function __invoke(ResetPasswordRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $passwordReset = ResetCodePassword::firstWhere('code', $request->code);

        if ($passwordReset->isExpire())
            return apiResponse(message:__('lang.code_is_expire'),code: 422);

        $user = User::firstWhere('phone', $passwordReset->phone);

        $user->update(['password'=>bcrypt($request->password)]);

        $passwordReset->delete();

        return apiResponse(message: __('lang.password_has_been_successfully_reset'));
    }
}
