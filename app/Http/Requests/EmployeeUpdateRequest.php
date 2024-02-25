<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends BaseRequest
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
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$this->employee,
            'phone' => 'required|string|unique:users,phone,'.$this->employee,
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'password' => 'sometimes|required|string|max:255|confirmed',
            'is_active' => 'nullable',
            'location_id' => 'required|integer',
            'permissions' => 'required|array',
            'permissions.*' => 'string|exists:permissions,name',
        ];
    }
}
