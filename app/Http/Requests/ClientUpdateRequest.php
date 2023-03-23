<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateRequest extends FormRequest
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
            'name' => 'required|array',
            'name.*' => 'string',
            'email' => 'required|email|unique:users,email,'.$this->client,
            'phone' => 'required|string|unique:users,phone,'.$this->client,
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'password' => 'sometimes|nullable|string|max:255',
            'is_active' => 'nullable',
            'allow_notification' => 'nullable',
            'location_id' => 'required|integer',
            'date_of_birth'=>'required|date'
        ];
    }

}
