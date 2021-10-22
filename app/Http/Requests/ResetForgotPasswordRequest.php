<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetForgotPasswordRequest extends FormRequest
{

    public function rules()
    {
        return [
            'email'    => 'required|email|exists:users',
            'password' => 'required|string|min:5|max:12'
        ];
    }
}
