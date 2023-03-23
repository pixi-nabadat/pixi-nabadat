<?php

namespace App\Services;


use App\Exceptions\UserNotFoundException;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AuthService extends BaseService
{

    public function loginWithUsernameOrPhone(string $identifier, string $password,$type = User::CUSTOMERTYPE) :User|Model
    {

        $identifierField = is_numeric($identifier) ? 'phone':'email';
        $credential = [$identifierField=>$identifier,'password'=>$password,'type'=>$type];
        if (!auth()->attempt($credential))
            return throw new UserNotFoundException(__('lang.login failed'));
        return User::where($identifierField, $identifier)->first();
    }


    /**
     * @param array $data
     * @return mixed
     */
    public function register(array $data=[]): mixed
    {
        return User::create($data);
    }

    public function getAuthUser()
    {
        return auth('sanctum')->user();
    }

    public function setUserFcmToken(User $user , $fcm_token)
    {
        if (isset($fcm_token))
            $user->update(['device_token'=>$fcm_token]);
    }
}
