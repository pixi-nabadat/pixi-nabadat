<?php

namespace App\Http\Requests;

use App\Models\Reservation;
use Illuminate\Foundation\Http\FormRequest;

class ReservationAttendRequest extends BaseRequest
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
            'qr_code'=>'required|exists:reservations,qr_code',
            'status'=>'required'
        ];
    }
 
    /**
     * Prepare the data for validation.
     *
     * @return m|ReservationAttendRequest
     */
    public function prepareForValidation()
    {
        return $this->merge(['status'=>Reservation::ATTEND]);
    }
}
