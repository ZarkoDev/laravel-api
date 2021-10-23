<?php

namespace App\Http\Services;

use App\Http\Traits\ErrorTrait;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;

class UserService
{
    use ErrorTrait;

    public function store($attributes)
    {
        $user = new User();
        $user->fill($attributes);

        if (!$user->save()) {
            $this->setError('User is not created');
            return false;
        }

        return true;
    }

    public function login($attributes)
    {
        $user = User::firstWhere('email', $attributes['email']);

        if (!$user || !$user->isValidPassword($attributes['password'])) {
            $this->setError('User is not found');
            return false;
        }

        $user->setNewToken();

        return $user;
    }

    public function changePassword($attributes)
    {
        $user = User::find(auth()->id());

        if (!$user) {
            $this->setError('User is not found');
            return false;
        }

        $user->password = $attributes['password'];
        $user->token = null;

        if (!$user->save()) {
            // TODO:: set response codes
            $this->setError('User password is not updated');
            return false;
        }

        return true;
    }

    public function sendForgottenPasswordLink($attributes)
    {
        return Password::sendResetLink($attributes);
    }

    public function resetForgottenPassword($attributes)
    {
        $resetStatus = Password::reset($attributes,
            function ($user, $password) {
                $user->password = $password;
                $user->save();
            }
        );

        if ($resetStatus !== Password::PASSWORD_RESET) {
            $this->setError('Unsuccessfully reset password');
            return false;
        }

        return true;
    }
}
