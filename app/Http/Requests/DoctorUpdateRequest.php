<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;


class DoctorUpdateRequest extends BaseRequest
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
            'name.*' => 'required|string',
            'phone' => 'required|numeric|unique:doctors,phone,'.$this->doctor,
            'description.*' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'center_id' => 'required|exists:centers,id',
            'age' => 'nullable|integer',
            'is_active' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'title.*.string' => __('lang.title_en_should_be_string'),
            'title.*.required' => __('lang.title_in_ar__should_be_required'),
        ];
    }

}
