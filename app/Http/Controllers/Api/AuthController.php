<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\UserNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AuthUserResource;
use App\Models\User;
use App\Services\AuthService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function login(LoginRequest $request)
    {

        try {
            $user = $this->authService->loginWithUsernameOrPhone(identifier: $request->identifier, password: $request->password);
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
        $data = array_merge($data,['type'=>User::CUSTOMERTYPE , 'email'=>$data['user_name']."@gmail.com",'last_login_at'=>now()]);
        $data['name'] = [
          'en'=>$data['name'],
          'ar'=>$data['name'],
        ];
        $result = $this->authService->register(data: $data);
        if ($result)
            return apiResponse($result,__('lang.success'),200);
        return apiResponse(message: __('lang.error_message'),code: 422);
    }


    public function profile()
    {
        try {
            $user = $this->authService->getAuthUser();
            return new AuthUserResource($user);
        }catch (\Exception $exception)
        {
            return apiResponse(message: $exception->getMessage() ,code: 422);
        }
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return apiResponse(message: __('lang.login success'));
    }
}
