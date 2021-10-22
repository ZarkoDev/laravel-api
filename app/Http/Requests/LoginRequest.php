<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    public function rules()
    {
        return [
            'email'    => 'required|email|exists:users',
            'password' => 'required|string|min:5|max:12'
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'The email does not exist',
        ];
    }
}
