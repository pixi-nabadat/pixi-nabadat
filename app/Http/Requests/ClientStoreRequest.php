<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'user_name' => 'required|string|unique:users,user_name',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'password' => 'required|string|max:255',
            'is_active' => 'nullable',
            'allow_notification' => 'nullable',
            'location_id' => 'required|integer',
            'date_of_birth' => 'nullable|date',
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(),['type'=>User::CUSTOMERTYPE]);
    }
}
