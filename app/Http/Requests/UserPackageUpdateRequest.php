<?php

namespace App\Http\Requests;

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
            'payment_status' => 'required|integer|in:'.PaymentStatusEnum::PAID.','.PaymentStatusEnum::UNPAID, 
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}