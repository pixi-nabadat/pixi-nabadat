<?php

namespace App\Http\Requests;

use App\Enum\CenterStatusEnum;
use App\Enum\PaymentMethodEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreCenterRequestApi extends BaseRequest
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
            'name'                   => 'required|array',
            'name.*'                 => 'required|string',
            'user_name'                 => 'required|string',
            'phones'                 => 'nullable|array',
            'phones.*'               => 'nullable|string',
            'location_id'            => 'required|integer',
            'primary_phone'          => 'required|string|unique:users,phone',
            'lat'                    => 'nullable|string',
            'lng'                    => 'nullable|string',
            'address'                => 'required|array',
            'address.*'              => 'string|required',
            'description'            => 'required|array',
            'description.*'           => 'string',
            'images'                  => 'nullable|array',
            'profile_image'           => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'logo'                    => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'images.*'                => 'image|mimes:jpg,png,jpeg,gif,svg',
            'password'                => 'required|string',
            'email'                   => 'required|email|unique:users,email',
            'is_support_auto_service' => 'string|nullable',
            'avg_waiting_time'         => 'required',
            'support_payments'        => 'required|array|min:1',
            'support_payments.*'      => 'string|in:'.PaymentMethodEnum::CREDIT.','.PaymentMethodEnum::CASH,
            'pulse_price'             => 'required|numeric|gt:0',
            'google_map_url'          => 'string|nullable',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge(['status'=>CenterStatusEnum::UNDER_REVIEWING]);
    }

    public function messages()
    {
        return [
            'phones.*.string' => __('lang.phone_en_should_be_string'),
            'name.*.required' => __('lang.title_in_ar_should_be_required'),
            'location_id.required' => __('lang.location_should_be_required'),
        ];
    }
}
