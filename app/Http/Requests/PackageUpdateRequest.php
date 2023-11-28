<?php

namespace App\Http\Requests;

use Carbon\Carbon;

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
            'name'                 => 'required|array',
            'name.*'               => 'required|string',
            'num_nabadat'          => 'required|integer',
            'price'                => 'required|numeric',
            'start_date'           => 'required|date',
            'end_date'             => 'required|date|after_or_equal:start_date',
            'discount_percentage'  => 'nullable|numeric',
            'image'                => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'status'               => 'nullable|integer',
            'is_active'            => 'nullable|string',
        ];
    }
}
