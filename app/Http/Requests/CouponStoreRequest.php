<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponStoreRequest extends BaseRequest
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
            'code' => 'required|string|unique:coupons',
            'discount_type'=>'required|float',
            'discount'=>'required|float',
            'start_date'=>'required|date',
            'end_date'=>'required|date',
            'min_buy'=>'required|numeric',
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), ['added_by' => auth()->id()]);
    }
}
