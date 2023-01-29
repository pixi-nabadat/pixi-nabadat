<?php

namespace App\Http\Requests;

use App\Enum\PaymentStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class ScheduleFcmUpdateRequest extends BaseRequest
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
            'title'=>'required|string',
            'content'=>'required|string',
            'trigger' =>'required|unique:schedule_fcms,trigger,'.$this->schedule_fcm,
            'start_date'=>'required|date',
            'end_date'=>'required|date',
            'notification_via'=>'required',
            'is_active' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}