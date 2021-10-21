<?php

namespace App\Http\Services;

use App\Http\Traits\ErrorTrait;
use App\Models\User;
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

    public function getLoginToken($attributes)
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
}
