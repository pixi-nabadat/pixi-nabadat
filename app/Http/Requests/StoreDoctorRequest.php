<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
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
            'center_id'         =>'required|exists:centers,id',
            'name.*'            =>'required|string',
            'phone'             =>'required|string',
            'description.*'     =>'string|nullable',
            'image'             =>'image|mimes:jpg,png,jpeg,gif,svg'
        ];
    }

    public function validationData(): array
    {
        return array_merge($this->all(),['center_id' => auth()->user()->center_id]);
    }
}
