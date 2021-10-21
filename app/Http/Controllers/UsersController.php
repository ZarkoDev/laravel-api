<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;

class UsersController extends Controller
{

    public function register(UserRegisterRequest $request)
    {
        $attributes = $request->getAttributes();

        return $attributes;
    }
}