<?php

namespace App\Http\Requests;

class RegisterRequest extends BaseRequest
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
            'email'=>'required|email|unique:users',
            'phone'=>'required|numeric|unique:users',
            'password'=>'required|string|confirmed|min:6',
            'date_of_birth'=>'required|date',
            'location_id'=>'required|integer|exists:locations,id'
        ];
    }
//
//    public function messages()
//    {
//       return[
//           'name.required'=>__(''),
//           'email.required'=>__(''),
//           'email.email'=>__(''),
//           'phone.required'=>__(''),
//           'phone.numeric'=>__(''),
//           'password.required'=>__(''),
//           'password.confirmed'=>__(''),
//           'password.min'=>__(''),
//           'date_of_birth.required'=>__(''),
//           'location_id.required'=>__(''),
//       ];
//    }
}
