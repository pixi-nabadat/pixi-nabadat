<?php

namespace App\Http\Requests;

use App\Models\User;

class LoginApiRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'identifier'=>'required|string',
            'password'=>'required',
            'fcm_token'=>'nullable|string',
            'remember' =>'nullable|boolean:in:[0,1]',
            'type'=>'nullable|in:'.User::SUPERADMINTYPE.','.User::CENTERADMIN.','.User::CUSTOMERTYPE
        ];
    }
}
