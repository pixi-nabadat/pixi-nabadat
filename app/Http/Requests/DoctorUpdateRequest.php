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
            'name' => 'required|string',
            'phone' => 'required|numeric',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'center_id' => 'required|exists:centers,id',
            'age' => 'required|integer',
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
