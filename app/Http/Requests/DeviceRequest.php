<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;


class DeviceRequest extends BaseRequest
{
    /**
     * Determine if the device is authorized to make this request.
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
            // 'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'description.*' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'name.*.string' => __('lang.name_en_should_be_string'),
            'name.*.required' => __('lang.name_in_ar__should_be_required'),

            'description.*.string' => __('lang.description_en_should_be_string'),
            'description.*.required' => __('lang.description_in_ar__should_be_required'),
        
        ];
    }

}
