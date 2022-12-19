<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RatesStoreRequest extends FormRequest
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
            'user_id'   => 'required|integer|exists:users,id',
            'item_type' => 'required|string|in:product,device',
            'item_id'   => 'required|integer',
            'comment'   => 'required|string',
            'rate_number'      => 'required|numeric',
        ];
    }
}
