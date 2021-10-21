<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserChangePasswordRequest;
use App\Http\Requests\UserForgotPasswordRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\UserLoginResource;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\Request;

class UsersController extends Controller
{

    public function register(UserRegisterRequest $request, UserService $userService)
    {
        $attributes = $request->validated();
        $user = $userService->store($attributes);

        if (!$user) {
            return $userService->getErrorResponse();
        }

        return response('Successfully created user');
    }

    public function login(UserLoginRequest $request, UserService $userService)
    {
        $attributes = $request->validated();
        $user = $userService->getLoginToken($attributes);

        if (!$user) {
            return $userService->getErrorResponse();
        }

        return new UserLoginResource($user);
    }

    public function changePassword(UserChangePasswordRequest $request, UserService $userService)
    {
        $attributes = $request->validated();
        $user = $userService->changePassword($attributes);

        if (!$user) {
            return $userService->getErrorResponse();
        }

        return response('Successfully changed password');
    }

    public function forgotPassword(UserForgotPasswordRequest $request, UserService $userService)
    {
        $attributes = $request->validated();
        $user = $userService->getForgottenPasswordHash($attributes);

        if (!$user) {
            return $userService->getErrorResponse();
        }

        return response('Successfully changed password');
    }
}
