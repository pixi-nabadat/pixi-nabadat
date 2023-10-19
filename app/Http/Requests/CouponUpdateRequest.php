<?php

namespace App\Http\Requests;

use Carbon\Carbon;

class CouponUpdateRequest extends BaseRequest
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
            'code' => 'required|string|unique:coupons,code,'.$this->coupon,
            'discount_type' => 'required',
            'discount'=>'required|numeric',
            'start_date'=>'required|date',
            'end_date'=>'required|date|after_or_equal:start_date',
            'min_buy'=>'required|numeric',
            'allowed_usage'=>'required|numeric',
            'coupon_for'=>'required',
            'is_active'=>'nullable|string'
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), ['added_by' => auth()->id()]);
    }
}
