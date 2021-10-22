<?php

namespace App\Http\Requests;

use App\Rules\DomainRule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{

    public function rules()
    {
        return [
            'domain' => ['required', new DomainRule()]
        ];
    }
}
