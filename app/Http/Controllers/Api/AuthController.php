<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\StoreFcmTokenRequest;
use App\Http\Resources\AuthUserResource;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function login(LoginRequest $request)
    {

        try {
            $user = $this->authService->loginWithUsernameOrPhone(identifier: $request->identifier, password: $request->password,type: $request->type);
            $this->authService->setUserFcmToken($user,$request->fcm_token);
            return new AuthUserResource($user);
        } catch (UserNotFoundException $e) {
            return apiResponse($e->getMessage(), 'Unauthorized', $e->getCode());
        }

    }

    public function register(RegisterRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $data = $request->validated();
        $data = array_merge($data, ['type' => User::CUSTOMERTYPE, 'last_login_at' => now()]);
        $data['name'] = [
            'en' => $data['name'],
            'ar' => $data['name'],
        ];
        $data['password'] = bcrypt($data['password']);
        $result = $this->authService->register(data: $data);
        if ($result)
            return apiResponse( trans('lang.success'));
        return apiResponse(message: __('lang.error_message'), code: 422);
    }


    public function profile(): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $user = Auth::user();
            return apiResponse(data: new AuthUserResource($user));
        } catch (\Exception $exception) {
            logger('auth user exception');
            return apiResponse(message: $exception->getMessage(), code: 422);
        }
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return apiResponse(message: __('lang.logout_success'));
    }

    public function setFcmToken(StoreFcmTokenRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $user = auth()->user() ;
        if (!$user)
            return apiResponse(message: trans('lang.Unauthenticated'));
        $this->authService->setUserFcmToken($user , $request->fcm_token);
        return apiResponse(message: trans('lang.success_operation'));
    }
}
