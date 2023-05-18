<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends BaseRequest
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
            'name.ar' => 'required|string',
            'name.en' => 'required|string',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'type' => 'required|in:'.Category::USERTYPE,','.Category::CENTERTYPT,
            'is_active' => 'nullable'
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
