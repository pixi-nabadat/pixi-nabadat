<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'user_id' => 'required|integer',
            'address' => 'string|required',
            'country_id' => 'required|integer',
            'governerate_id' => 'required|integer',
            'city_id' => 'required|integer',
            'postal_code' => 'required|string',
            'is_default' => 'nullable',
            'lat' => 'nullable|string',
            'lng' => 'nullable|string',
            'phone' => 'string|required',
        ];
    }
}
