<?php

namespace App\Http\Requests;

use App\Models\Reservation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReservationHistoryStoreRequest extends BaseRequest
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
            'status' => ['required','integer',Rule::in(Reservation::CONFIRMED,Reservation::ATTEND,Reservation::COMPLETED,Reservation::CANCELED)],
            'period'=>'required_if:status,==,'.Reservation::CONFIRMED,
            'check_date'=>'required_if:status,==,'.Reservation::CONFIRMED,
            'cancel_reason_id'=>[Rule::requiredIf($this->status == Reservation::CANCELED),Rule::exists('cancel_reasons','id')],
            'comment'=>'string|nullable'
        ];
    }

    public function messages()
    {
        return[
            'required_if' => 'The :attribute field is required when :other is Confirmed.',
        ];
    }
}
