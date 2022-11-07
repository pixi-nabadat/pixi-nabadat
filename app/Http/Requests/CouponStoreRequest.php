<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponStoreRequest extends FormRequest
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
            'discount'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'min_buy'=>'required',
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }
}
