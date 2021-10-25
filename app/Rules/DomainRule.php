<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DomainRule implements Rule
{

    public function passes($attribute, $value)
    {
        return preg_match('/^(?!:\/\/)(?=.{1,255}$)((.{1,63}\.){1,127}(?![0-9]*$)[a-z0-9-]+\.?)$/i', $value);
    }

    public function message()
    {
        return __('custom.domain_invalid');
    }
}
