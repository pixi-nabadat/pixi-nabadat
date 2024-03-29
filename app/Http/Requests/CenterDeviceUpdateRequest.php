<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CenterDeviceUpdateRequest extends BaseRequest
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
            'auto_service'=>'nullable|string',
            'is_active'=>'nullable|string',
            'number_of_devices'=>'required|numeric',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'primary_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ];
    }

}
