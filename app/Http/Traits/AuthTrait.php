<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

trait AuthTrait
{

    public function generatePassword($value)
    {
        return Hash::make($value);
    }

    public function isValidPassword($value)
    {
        return Hash::check($value, $this->password);
    }

    public function generateNewLoginToken()
    {
        return hash('sha256', Str::random(60));
    }
}
