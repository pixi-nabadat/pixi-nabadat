<?php

namespace App\Http\Requests;


use Carbon\Carbon;

class SliderStoreRequest extends BaseRequest
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
            'order'      => 'required|integer',
            'package_id' => 'required|integer|exists:packages,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date',
            'is_active'  => 'nullable|string',
        ];
    }

    public function prepareForValidation()
    {
        return [
            'start_date'=>Carbon::parse($this->start_date)->format('Y-m-d'),
            'end_date'=>Carbon::parse($this->end_date)->format('Y-m-d'),
        ];
    }

}
