<?php

namespace App\Services;


use App\Exceptions\UserNotFoundException;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AuthService extends BaseService
{

    public function loginWithEmailOrPhone(string $identifier, string $password,int $userType=null) :User|Model
    {

        $identifierField = filter_var($identifier,FILTER_VALIDATE_EMAIL) ? 'email':'phone';
        $credential = [$identifierField=>$identifier,'password'=>$password];
        if (isset($userType))
            $credential['type']=User::CUSTOMERTYPE;
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
}
