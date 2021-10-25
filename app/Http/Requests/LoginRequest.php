<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    public function rules()
    {
        return [
            'email'    => 'required|email|exists:users',
            'password' => 'required|alpha_num|min:5|max:12'
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => __('custom.user_not_found'),
        ];
    }
}
