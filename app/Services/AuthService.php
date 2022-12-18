<?php

namespace App\Services;


use App\Exceptions\UserNotFoundException;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class AuthService extends BaseService
{

    public function loginWithUsernameOrPhone(string $identifier, string $password) :User|Model
    {

        $identifierField = is_numeric($identifier) ? 'phone':'user_name';
        $credential = [$identifierField=>$identifier,'password'=>$password];
        if (!auth()->attempt($credential))
            return throw new UserNotFoundException(__('lang.login failed'));
        return User::where($identifierField, $identifier)->first();


    }

    public function socialLogin(array $data, string $provider) :User|Model
    {

        $provider_token = $data['token'];
        $type           = $data['type'];

        $socialUser = Socialite::driver($provider)->userFromToken($provider_token);
        if($socialUser == null)
            return throw new UserNotFoundException(__('lang.login failed'));
        $user = User::firstOrCreate([
            'email' => $socialUser->email,
        ], [
            'name'      => $socialUser->getName(),
            'email'     => $socialUser->getEmail(),
            'user_name'  => Str::lower(Str::beforeLast($socialUser->getEmail(), '@')),
            'password'  => bcrypt($socialUser->getEmail()),
            'phone'     => $socialUser->getId(),
            'type'      => $type,
            'is_active' => true,

        ]);
        Auth::login($user);
        return $user;


    }


    /**
     * @param array $data
     * @return mixed
     */
    public function register(array $data=[]): mixed
    {
        return User::create($data);
    }

    public function getAuthUser(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        return auth()->user();
    }
}
