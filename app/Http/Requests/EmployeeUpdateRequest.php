<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email,'.$this->employee,
            'phone' => 'required|string|unique:users,phone,'.$this->employee,
            'user_name' => 'required|string|unique:users,user_name,'.$this->employee,
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'is_active' => 'nullable',
            'location_id' => 'required|integer',
            'date_of_birth' => 'nullable|date',
            'permissions' => 'required|array',
            'permissions.*' => 'string|exists:permissions,name',
        ];
    }
}