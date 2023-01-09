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
            'discount_type'=>'required',
            'discount'=>'required|numeric',
            'start_date'=>'required|date',
            'end_date'=>'required|after_or_equal:start_date',
            'min_buy'=>'required|numeric',
            'allowed_usage'=>'required|numeric',
            'coupon_for'=>'required',
            'added_by'=>'required|exists:users,id'
        ];
    }

    public function validationData(): array
    {
        return array_merge($this->all(), ['added_by' => auth()->id()]);
    }
}
