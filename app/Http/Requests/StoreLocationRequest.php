<?php

namespace App\Http\Requests;

class StoreLocationRequest extends BaseRequest
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
        $rul =   [
            'title_en' => 'required|string',
            'title_ar' => 'required|string',
        ];

        if (isset($this->parent_id)) {
            $rules['parent_id'] = 'required|integer';
        } else {
            $rules['currency_id'] =  'required|integer';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'title_en.string' => __('lang.title_en_should_be_string'),
            'title_en.required' => __('lang.title_en_should_be_required'),
            'title_ar.required' => __('lang.title_ar_should_be_required'),
            'title_en.required' => __('lang.title_ar_should_be_required'),
            'currency_id.required' => __('lang.currency_should_be_required'),
            'parent_id.required' => __('lang.parent_should_be_required'),
        ];
    }
}
