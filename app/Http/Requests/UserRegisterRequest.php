<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{

    public function rules()
    {
        return [
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:5|max:12'
        ];
    }
}