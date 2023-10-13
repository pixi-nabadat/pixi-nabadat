<?php

namespace App\Http\Requests;

use App\Enum\PaymentMethodEnum;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReservationUpdateRequest extends BaseRequest
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
           'period'=>'required|in:am,pm',
           'check_date'  => 'required|date|after_or_equal:'.Carbon::now()->setTimezone('Africa/Cairo')->format('Y-m-d'),
        ];
    }
}