<?php

namespace App\Http\Requests;

use App\Enum\PaymentMethodEnum;
use App\Enum\PaymentStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class UserPackageUpdateRequest extends BaseRequest
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
            'user_id'=>'required|exists:users,id',
            'center_id'=>'required|exists:centers,id',
            'num_nabadat'=>'required|numeric',
            'price'=>'required|numeric',
            'discount_percentage'=>'nullable|numeric',
            'payment_method'=>'required|in:'.PaymentMethodEnum::CASH.','.PaymentMethodEnum::CREDIT,
            'payment_status'=>'required',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}