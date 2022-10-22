<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;


class DoctorUpdateRequest extends BaseRequest
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

            'user_name' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,'. $this->doctor,
            'phone' => 'required|email|unique:users,'. $this->doctor,
            'password' => 'sometimes|nullable|string',
            'date_of_birth' => 'required|date',
            'location_id' => 'required|integer|exists:locations,id',
            'description' => 'nullable|string'

        ];
    }

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
