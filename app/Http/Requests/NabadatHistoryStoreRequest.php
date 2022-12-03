<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NabadatHistoryStoreRequest extends FormRequest
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
            'reservation_id' => 'required|exists:reservations,id',
            'device_id'      => 'required|exists:devices,id',
            'num_nabadat'    => 'required|numeric',
        ];
    }
}
