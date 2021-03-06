<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{

    public function rules()
    {
        return [
            'password' => 'required|alpha_num|min:5|max:12'
        ];
    }
}
