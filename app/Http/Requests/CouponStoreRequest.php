<?php

namespace App\Http\Requests;

use Carbon\Carbon;
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
            'discount'=>'required|numeric',
            'start_date'=>'required|date|after_or_equal:'.Carbon::now()->setTimezone('Africa/Cairo')->format('Y-m-d'),
            'end_date'=>'required|date|after_or_equal:start_date',
            'min_buy'=>'required|numeric',
            'allowed_usage'=>'required|numeric',
            'coupon_for'=>'required',
            'added_by'=>'required|exists:users,id',
            'is_active'=>'nullable|string',
        ];
    }

    public function validationData(): array
    {
        return array_merge($this->all(), ['added_by' => auth()->id()]);
    }
}
