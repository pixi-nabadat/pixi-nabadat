<?php

namespace App\Http\Requests;

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
            'package_id'        => 'required|integer',
            'payment_method'    => 'integer|required',
            'user_id'           => 'required'
        ];
    }

    public function validationData(): array
    {
        return array_merge($this->all(), ['user_id' => auth('auth:sanctum')->id()]);
    }
}
