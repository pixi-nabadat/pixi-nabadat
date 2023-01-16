<?php

namespace App\Services;


use App\Exceptions\UserNotFoundException;
use App\Models\Center;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public function loginCenterWithUsernameOrPhone(string $identifier, string $password) :User|Model
    {

        $identifierField = is_numeric($identifier) ? 'phone':'user_name';
        $credential = [$identifierField=>$identifier,'password'=>$password];
        if (!auth('center')->attempt($credential))
            return throw new UserNotFoundException(__('lang.login failed'));
        return Center::where($identifierField, $identifier)->first();
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
        return Auth::user();
    }
}
