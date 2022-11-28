<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartStoreRequest extends FormRequest
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
            'user_id'       => 'nullable|exists:users,id',
            'discount'      => 'nullable|numeric',
            'sub_total'     => 'nullable|numeric',
            'net_total'     => 'nullable|numeric',
            'grand_total'   => 'nullable|numeric',
            'tax'           => 'nullable|numeric',
            'shipping_cost' => 'required|numeric',
            'temp_user_id'  => 'required|string',
            'address_id'    => 'nullable|string',
        ];
    }
}
