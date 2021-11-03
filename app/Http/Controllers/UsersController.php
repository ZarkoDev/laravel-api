<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetForgotPasswordRequest;
use App\Http\Resources\UserLoginResource;
use App\Http\Services\UserService;

class UsersController extends Controller
{

    public function register(RegisterRequest $request, UserService $userService)
    {
        $attributes = $request->validated();
        $userService->store($attributes);

        return response(__('custom.user_creation_success'), static::STATUS_CODE_CREATED);
    }

    public function login(LoginRequest $request, UserService $userService)
    {
        $attributes = $request->validated();
        $user = $userService->login($attributes);

        return new UserLoginResource($user);
    }

    public function forgotPassword(ForgotPasswordRequest $request, UserService $userService)
    {
        $attributes = $request->validated();
        $status = $userService->sendForgottenPasswordLink($attributes);

        return response(__('custom.' . $status));
    }

    public function resetForgotPassword(ResetForgotPasswordRequest $request, UserService $userService)
    {
        $attributes = $request->validated();
        $attributes['token'] = $request->token;
        $userService->resetForgottenPassword($attributes);

        return response(__('custom.password_reset_success'));
    }

    public function changePassword(ChangePasswordRequest $request, UserService $userService)
    {
        $attributes = $request->validated();
        $userService->changePassword($attributes);

        return response(__('custom.change_password_success'));
    }
}
