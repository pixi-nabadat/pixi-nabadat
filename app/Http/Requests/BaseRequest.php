<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;


class BaseRequest extends FormRequest
{
    //extend it if you validate api request
   public function failedValidation(Validator $validator)
   {
      if ($this->expectsJson())
          throw new HttpResponseException(response(['message'=>__('lang.invalid inputs'),'errors'=>$validator->errors()],422));

      throw (new ValidationException($validator))
           ->errorBag($this->errorBag)
           ->redirectTo($this->getRedirectUrl());
   }
}
