<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReservationStoreRequestApi extends BaseRequest
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
            'customer_id' => ['required','exists:users,id', Rule::unique('reservations')->where(function ($query) {
                return $query->where('check_date', $this->check_date);
            })],
            'center_id'   => 'required|exists:centers,id',
            'check_date'  => 'required|date|after_or_equal:'.Carbon::now()->setTimezone('Africa/Cairo')->format('Y-m-d'),
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(),['customer_id'=>auth('sanctum')->id()]);
    }

    public function messages()
    {
        return [
            'customer_id.unique'=>trans('lang.already_has_reservation_for_this_day')
        ] ;
    }
}