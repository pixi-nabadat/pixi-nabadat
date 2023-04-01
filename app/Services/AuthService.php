<?php

namespace App\Services;

use App\Enum\ImageTypeEnum;
use App\Exceptions\UserNotFoundException;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public function update(User $user, array $data)
    {
        return $user->update($data);
    }

    public function updateLogo(array $data)
    {
        $user = User::find(Auth::user()->id);
        if (isset($data['logo'])) {
            $user->deleteAttachmentsLogo();
            $fileData = FileService::saveImage(file: $data['logo'], path: 'uploads/users', field_name: 'logo');
            $fileData['type'] = ImageTypeEnum::LOGO;
            $user->storeAttachment($fileData);
        }
        return $user;

    }
    public function setUserFcmToken(User $user , $fcm_token)
    {
        if (isset($fcm_token))
            $user->update(['device_token'=>$fcm_token]);
    }
}
