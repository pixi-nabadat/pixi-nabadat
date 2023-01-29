<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartAddressRequest extends BaseRequest
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
            'temp_user_id' => 'required',
            'address_id' => 'integer|required|exists:addresses,id',
            'user_id' => 'required|exists:users,id',
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(),['user_id'=>auth()->id()]);
    }
}
