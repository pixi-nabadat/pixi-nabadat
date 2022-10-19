<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;


class DoctorRequest extends BaseRequest
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
        if (request()->routeIS('doctors.store')) {

            $userNameRule = 'unique:users';
            $emailRule = 'unique:users';
            $phoneRule = 'unique:users';
            $password =['required','string','min:6','confirmed'];

        } elseif (request()->routeIS('doctors.update')) {

            $userNameRule = 'unique:users,user_name,' . $this->doctor;
            $emailRule = 'unique:users,email,' . $this->doctor;
            $phoneRule = 'unique:users,phone,' . $this->doctor;
            $password ='confirmed';
            
        }

        return [
            
            'user_name' => ['required', $userNameRule],
            'name' => 'required',
            'email' => ['required', 'email', $emailRule],
            'phone' => ['required', 'numeric', $phoneRule],
            'password' => $password,
            'date_of_birth' => 'required|date',
            'location_id' => 'required|integer|exists:locations,id',
            'description' => 'nullable|string'

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
