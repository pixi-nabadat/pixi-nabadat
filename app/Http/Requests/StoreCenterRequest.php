<?php

namespace App\Http\Requests;

class StoreCenterRequest extends BaseRequest
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
            'name.*' => 'required|string',
            'phone' => 'required|string',
            'location_id' => 'required|integer',
            'lat' => 'nullable|string',
            'lng' => 'nullable|string',
            'address.*' => 'string|required',
            'description.*' => 'string|nullable',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'user_name'=>'required|unique:users,user_name',
            'password'=>'required|string',
            'email'=>'required|email|unique:users,email'
        ];
    }
}
