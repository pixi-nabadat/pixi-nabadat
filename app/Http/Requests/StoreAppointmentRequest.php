<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAppointmentRequest extends BaseRequest
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
            'days' => 'required|array|min:1',
            'days.*' => [
                Rule::unique('appointments','day_of_week')->where(function ($query){
                return $query->where('center_id', $this->center_id);
            })],
            'center_id'=>'required|exists:users,id'
        ];
    }

    public function validationData(): array
    {
        return array_merge($this->all(), ['center_id' => optional(auth()->user())->center_id]);
    }
}