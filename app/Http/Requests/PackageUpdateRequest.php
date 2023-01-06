<?php

namespace App\Http\Requests;


class PackageUpdateRequest extends BaseRequest 
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
            'center_id'            => 'required|exists:centers,id',
            'name.*'               => 'required|string|unique:packages,name,'.$this->package,
            'num_nabadat'          => 'required|integer',
            'price'                => 'required|numeric',
            'start_date'           => 'required|date',
            'end_date'             => 'required|date',
            'discount_percentage'  => 'required|numeric',
            'image'                => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'status'               => 'nullable|integer',
            'is_active'            => 'nullable|string',
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
