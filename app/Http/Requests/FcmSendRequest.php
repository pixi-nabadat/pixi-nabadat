<?php

namespace App\Http\Requests;

class FcmSendRequest extends BaseRequest
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
            'users' => 'required_without_all:centers,locations',
            'centers' => 'required_without_all:centers,locations',
            'locations' => 'required_without_all:users,centers',
            'title'=>'required|string',
            'fcm_content'=>'required|string',
        ];
    }
}
