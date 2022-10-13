<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
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
            $userType = User::CUSTOMERTYPE ;
            $user = $this->authService->loginWithEmailOrPhone(identifier: $request->identifier, password: $request->password,userType: $userType);
            $data = [
                'token'=>$user->getToken(),
                'token_type'=>'Bearer',
                'user'=>$user
            ];
            return apiResponse($data,__('lang.login success'));
        }catch (UserNotFoundException $e) {
            return apiResponse($e->getMessage(), 'Unauthorized',$e->getCode());
        }

    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['type'] = User::CUSTOMERTYPE;
        $result = $this->authService->register(data: $data);
        if ($result)
            return apiResponse($result,__('lang.success'),200);
        return apiResponse(data: null,message: __('lang.error_message',422));    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return apiResponse(message: __('lang.login success'));
    }
}
