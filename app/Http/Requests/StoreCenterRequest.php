<?php

namespace App\Http\Requests;

use App\Enum\PaymentMethodEnum;

class StoreCenterRequest extends BaseRequest
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
            'name.*'                  => 'required|string',
            'phone'                   => 'array|min:1',
            'phone.*'                 => 'required|string|unique:users,phone',
            'location_id'             => 'required|integer',
            'lat'                     => 'nullable|string',
            'lng'                     => 'nullable|string',
            'address.*'               => 'string|required',
            'description.*'           => 'string|nullable',
            'images'                  => 'nullable|array',
            'images.*'                => 'image|mimes:jpg,png,jpeg,gif,svg',
            'user_name'               => 'required|unique:users,user_name',
            'password'                => 'required|string',
            'email'                   => 'required|email|unique:users,email',
            'is_active'               => 'string|nullable',
            'is_support_auto_service' => 'string|nullable',
            'avg_wating_time'         => 'required',
            'featured'                => 'nullable',
            'support_payments'        => 'array|min:1',
            'support_payments.*'      => 'required|string|in:'.PaymentMethodEnum::CREDIT.','.PaymentMethodEnum::CASH,
            'app_discount'            => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'phone.*.string' => __('lang.phone_en_should_be_string'),
            'name.*.required' => __('lang.title_in_ar__should_be_required'),
            'location_id.required' => __('lang.location_should_be_required'),
            'user_name.required' => __('lang.user_name_should_be_required'),
        ];
    }
}
