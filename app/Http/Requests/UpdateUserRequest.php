<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name'=>'required|string',
            'phone'=>'required|string|unique:users,phone,'.$this->user,
            'email'=>'required|email|unique:users,email,'.$this->user,
            'password'=>'required|string|confirmed|min:6',
            'date_of_birth'=>'nullable|date',
            'location_id'=>'nullable|integer|exists:locations,id',
        ];
    }

}
