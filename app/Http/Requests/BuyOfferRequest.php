<?php

namespace App\Http\Requests;

use App\Enum\PaymentMethodEnum;
use Illuminate\Foundation\Http\FormRequest;

class BuyOfferRequest extends BaseRequest
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
            'offer_id'        => 'required|integer',
            'payment_method'  => 'required|in:'.PaymentMethodEnum::CREDIT.','.PaymentMethodEnum::CASH.','.PaymentMethodEnum::POINTS,
        ];
    }
}
