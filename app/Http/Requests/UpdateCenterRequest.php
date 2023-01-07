<?php

namespace App\Http\Requests;

use App\Enum\PaymentMethodEnum;

class UpdateCenterRequest extends BaseRequest
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
            'phone' => 'array|min:1',
            'phone.*' => 'required|string',
            'location_id' => 'required|integer',
            'lat' => 'nullable|string',
            'lng' => 'nullable|string',
            'address.*' => 'string|required',
            'description.*' => 'string|nullable',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            // 'user_name'=>'required|unique:users,user_name',
            // 'password'=>'required|string',
            // 'email'=>'required|email|unique:users,email',
            // 'date_of_birth' => 'nullable|date',
            'is_active' => 'between:0,1',
            'is_support_auto_service' => 'between:0,1',
            'avg_wating_time'=>'required',
            'featured'=>'nullable',
            'support_payments'=> 'array|min:1',
            'support_payments.*'=> 'required|string|in:'.PaymentMethodEnum::CASH.','.PaymentMethodEnum::CREDIT,
        ];
    }

    public function messages()
    {
        return [
            'phone.*.string' => __('lang.phone_en_should_be_string'),
            'name.*.required' => __('lang.title_in_ar__should_be_required'),
            'location_id.required' => __('lang.location_should_be_required'),
            // 'user_name.required' => __('lang.user_name_should_be_required'),
        ];
    }
}
