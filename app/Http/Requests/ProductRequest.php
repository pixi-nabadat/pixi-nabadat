<?php

namespace App\Http\Requests;

use Carbon\Carbon;
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
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'discount'=>'required',
            'discount_start_date'=>'nullable|date',
            'discount_end_date'=>'nullable|date|after_or_equal:discount_start_date',
            'tax'=>'nullable',
            'featured'=>'nullable|string',
            'is_active'=>'nullable|string',
            'category_id'=>'required|exists:categories,id',
            'type'=>'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.*.string' => __('lang.name_should_be_string'),
            'name.*.required' => __('lang.name_should_be_required'),
        ];
    }
}
