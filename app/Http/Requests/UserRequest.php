<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'cedula' => 'required|between:7,8',
            'email' => 'required|email|max:50|unique:users,email'.$this->id,
            'password' => 'required|confirmed|between:8,15',
            'password_confirmation' => 'required|between:8,15',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
                response()->json([
                    'status' => false,
                    'message' => 'Validation errors',
                    'data' => $validator->errors()
                ])->setStatusCode(400)
            );
    }
}
