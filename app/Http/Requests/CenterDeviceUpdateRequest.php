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
            'regular_price'=>'required|numeric',
            'nabadat_app_price'=>'required|numeric',
            'auto_service_price'=>'required|numeric',
            'number_of_devices'=>'required|numeric',
        ];
    }

}
