<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClinicRequest extends FormRequest
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
            'name'=>'required|string',
            'address'=>'string|required',
            'lat'=>'nullable|string',
            'lng'=>'nullable|string',
            'phones'=>'string|required',
            'doctor_id'=>['integer',
                Rule::exists('users', 'id')
                    ->where('type', User::DOCTORTYPE),
                ],
            'location_id'=>'required|exists:locations,id',
        ];
    }
}
