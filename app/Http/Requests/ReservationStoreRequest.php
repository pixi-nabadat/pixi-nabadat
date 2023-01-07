<?php

namespace App\Http\Requests;

use App\Enum\PaymentMethodEnum;
use Illuminate\Foundation\Http\FormRequest;

class ReservationStoreRequest extends BaseRequest
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
            'customer_id' => 'required|exists:users,id',
            'center_id'   => 'required|exists:centers,id',
            'check_date'  => 'required|date',
            'payment_type' => 'required|in:'.PaymentMethodEnum::CASH.','.PaymentMethodEnum::CREDIT.','.PaymentMethodEnum::POINTS,
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(),['customer_id'=>auth('sanctum')->id()]);
    }
}
