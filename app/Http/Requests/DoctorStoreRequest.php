<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;


class DoctorStoreRequest extends BaseRequest
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
            'name.ar' => 'required|string',
            'name.en' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'date_of_birth' => 'required|date',
            'location_id' => 'required|integer|exists:locations,id',
            'description' => 'nullable|string'

        ];
    }

    public function messages()
    {
        return [
            'title.*.string' => __('lang.title_en_should_be_string'),
            'title.*.required' => __('lang.title_in_ar__should_be_required'),
        ];
    }

}
