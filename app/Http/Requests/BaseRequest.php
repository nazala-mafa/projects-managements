<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use \Illuminate\Contracts\Validation\Validator;

class BaseRequest extends FormRequest
{
  protected function failedValidation(Validator $validator)
  {
    $response = response()->json([
      'message' => 'Invalid data',
      'errors' => $validator->errors()
    ], 400);

    throw new ValidationException($validator, $response);
  }
}