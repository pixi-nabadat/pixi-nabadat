<?php

namespace App\Http\Controllers;

use App\Exceptions\UserNotFoundException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use Session;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function index()
    {
        return view('authentication.login');
    }

    public function login(LoginRequest $request)
    {
        try {
            $this->authService->loginWithEmailOrPhone(identifier: $request->identifier, password: $request->password);
            $toast = [
                'type'=>'success',
                'message'=>__('lang.sign_in'),
                'title'=>'ok'
            ];
            return redirect()->route('/')->with('toast',$toast);
        }catch (UserNotFoundException $e) {
            $toast=[
              'type'=>'error',
              'title'=>'error',
              'message'=>  $e->getMessage()
            ];
           return redirect()->route('login')->with('toast',$toast);
        }

    }

    public function registerForm(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('authentication.sign-up');
    }


    public function register(RegisterRequest $request)
    {

    }


    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
}
