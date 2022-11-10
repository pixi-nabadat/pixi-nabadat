<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;


class BaseRequest extends FormRequest
{
    //extend it if you validate api request
   public function failedValidation(Validator $validator)
   {
      if ($this->expectsJson())
      {
          $mappedErrors = collect($validator->errors())->map(function ($error, $key) {
              return [
                  "key" => $key,
                  "error" => Arr::first($error),
              ];
          })->values()->toArray();
          throw new HttpResponseException(response(['message'=>__('lang.invalid inputs'),'errors'=>$mappedErrors],422));
      }

      throw (new ValidationException($validator))
           ->errorBag($this->errorBag)
           ->redirectTo($this->getRedirectUrl());
   }
}
