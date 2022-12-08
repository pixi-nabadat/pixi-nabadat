<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends BaseRequest
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
            'stock'=>'required',
            'description.*'=>'required|string',
            'unit_price'=>'required',
            'purchase_price'=>'required',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'discount'=>'required',
            'discount_type'=>'required',
            'discount_start_date'=>'required',
            'discount_end_date'=>'required',
            'tax'=>'required',
            'tax_type'=>'required',
            'featured'=>'nullable|string',
            'is_active'=>'nullable|string',
            'category_id'=>'required|exists:categories,id'
        ];
    }

    public function messages()
    {
        return [
            'name.*.string' => __('lang.name_should_be_string'),
            'name.*.required' => __('lang.name__should_be_required'),
        ];
    }
}
