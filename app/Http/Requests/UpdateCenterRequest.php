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
            'name'                   => 'required|array',
            'name.*'                  => 'required|string',
            'phones'                   => 'nullable|array',
            'phones.*'                 => 'string|required|unique:users,phone',
            'location_id'             => 'required|integer',
            'lat'                     => 'nullable|string',
            'lng'                     => 'nullable|string',
            'address'               => 'required|array',
            'address.*'               => 'string|required',
            'description'           => 'required|array',
            'description.*'           => 'string|nullable',
            'images'                  => 'nullable|array',
            'logo'                    => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
            'images.*'                => 'image|mimes:jpg,png,jpeg,gif,svg',
            'user_name'               => 'required',
            'password'                => 'required|string',
            'email'                   => 'required',
            'is_active'               => 'nullable|string',
            'is_support_auto_service' => 'string|nullable',
            'avg_waiting_time'         => 'required',
            'featured'                => 'nullable|string',
            'support_payments'        => 'array',
            'support_payments.*'      => 'required|string',
            'app_discount'            => 'required|numeric',
            'google_map_url'            => 'string|nullable',
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
