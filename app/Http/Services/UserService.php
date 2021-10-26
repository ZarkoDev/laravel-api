<?php

namespace App\Http\Services;

use App\Exceptions\CreationFailedException;
use App\Exceptions\PasswordResetException;
use App\Exceptions\UpdateFailedException;
use App\Exceptions\NotFoundException;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class UserService extends BaseService
{

    public function store(array $attributes)
    {
        $user = new User();
        $user->fill($attributes);

        if (!$user->save()) {
            throw new CreationFailedException(__('custom.user_creation_failed'), static::STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(array $attributes)
    {
        $user = User::firstWhere('email', $attributes['email']);

        if (!$user || !$user->isValidPassword($attributes['password'])) {
            throw new NotFoundException(__('custom.user_not_found'), static::STATUS_NOT_FOUND);
        }

        $user->setNewToken();

        return $user;
    }

    public function changePassword(array $attributes)
    {
        $user = User::find(auth()->id());

        if (!$user) {
            throw new UserNotFoundException(__('custom.user_not_found'), static::STATUS_NOT_FOUND);
        }

        $user->password = $attributes['password'];
        $user->token = null;

        if (!$user->save()) {
            throw new UpdateFailedException(__('custom.password_update_failed'), static::STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function sendForgottenPasswordLink(array $attributes)
    {
        return Password::sendResetLink($attributes);
    }

    public function resetForgottenPassword(array $attributes)
    {
        $resetStatus = Password::reset($attributes,
            function ($user, $password) {
                $user->password = $password;
                $user->save();
            }
        );

        if ($resetStatus !== Password::PASSWORD_RESET) {
            throw new PasswordResetException(__('custom.reset_password_failed'), static::STATUS_INTERNAL_SERVER_ERROR);
        }
    }
}
