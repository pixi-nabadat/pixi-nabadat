<?php

namespace App\Http\Requests;


class SliderUpdateRequest extends BaseRequest 
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
            'order'      => 'required|integer',
            'center_id' => 'required|integer|exists:centers,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date',
            'is_active'  => 'nullable|string',
        ];
    }

}
