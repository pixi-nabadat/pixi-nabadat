<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
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
            'name' => 'required|array',
            'name.*' => 'string',
            'email' => 'required|email|unique:users,email,'.$this->user,
            'phone' => 'required|string|unique:users,phone,'.$this->user,
            'password' => 'sometimes|required|string|max:255',
            'location_id' => 'required|integer',
        ];
    }
}
