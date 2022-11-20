<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CancelReasonRequest extends FormRequest
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
            'reason.ar' => 'required|string',
            'reason.en' => 'required|string',
            'is_active' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'reason.*.string' => __('lang.reason_should_be_string'),
            'reason.*.required' => __('lang.reason__should_be_required'),
        ];
    }
}
