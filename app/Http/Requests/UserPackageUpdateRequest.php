<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPackageUpdateRequest extends FormRequest
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
            'payment_status' => 'required|integer', 
            'usage_status'   => 'required|integer',//this is the first status for new user packages
            'used'           => 'required|integer',
            'remaining'      => 'required|integer',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}