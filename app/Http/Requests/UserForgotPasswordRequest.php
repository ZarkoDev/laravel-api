<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserForgotPasswordRequest extends FormRequest
{

    public function rules()
    {
        return [
            'email'    => 'required|email|exists:users',
        ];
    }
}
