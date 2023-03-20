<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CenterDeviceStoreRequest extends BaseRequest
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
            'center_id'=>'required|exists:centers,id',
            'device_id'=>[
                'required',
                Rule::exists('devices','id'),
                Rule::unique('center_devices')->where('center_id',auth()->user()->center_id)],
            'auto_service'=>'nullable|string',
            'number_of_devices'=>'required|integer',
            'primary_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:5000',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:5000',
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(),['center_id'=>auth()->user()->center_id]);
    }
}
