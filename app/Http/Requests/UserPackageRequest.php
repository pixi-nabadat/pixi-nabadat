<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPackageRequest extends FormRequest
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
            'num_nabadat' => 'required',
            'price'=>'required',
            'package_id'=>'required|integer',
            'user_id'=>'required|integer'
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }
}
