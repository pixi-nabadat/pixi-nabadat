<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPackageStoreRequest extends FormRequest
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
            'package_id'     => 'required|integer',
            'user_id'        => 'required|integer|exists:users,id',
            'payment_method' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }
}