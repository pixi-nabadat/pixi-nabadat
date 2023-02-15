<?php

namespace App\Http\Requests;

class StoreDoctorRequest extends BaseRequest
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
            'name.*' => 'required|string',
            'phone' => 'required|string',
            'description.*' => 'string|nullable',
            'image' => 'image|mimes:jpg,png,jpeg,gif,svg',
            'is_active' => 'nullable'
        ];
    }

    public function validationData(): array
    {
        return array_merge($this->all(), ['center_id' => auth()->user()->center_id]);
    }
}
