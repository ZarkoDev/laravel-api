<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UserRegisterRequest extends FormRequest
{

    // public function authorize()
    // {
    //     return true;
    // }


    public function rules()
    {
        return [
            'email'    => 'required|email', // |unique:users
            'password' => 'required|string|min:5|max:12'
        ];
    }

    public function getAttributes()
    {
        return array_merge(
            $this->only(['email']),
            ['password' => Hash::make($this->get('password'))]
        );
    }
}
