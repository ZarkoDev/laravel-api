<?php

namespace Tests;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

abstract class BaseAuthTest extends TestCase
{
    const PASSWORD_DEFAULT = '1a2s3dGG';
    const EMAIL_INVALID = 'test.gmail.com';
    const PASSWORD_INVALID = '123456*';
    const PASSWORD_TOO_LONG = '123456789asdfghjkl';

    const STATUS_SUCCESS = 200;
    const STATUS_CREATED = 201;
    const STATUS_BAD_REQUEST = 400;
    const STATUS_UNAUTHORIZED = 401;
    const STATUS_FORBIDDEN = 403;
    const STATUS_NOT_FOUND = 404;
    const STATUS_UNPROCESSABLE_ENTITY = 422;
    const STATUS_INTERNAL_SERVER_ERROR = 500;

    private $user;
    private $userResetPasswordToken;

    protected $emailInvalidStructure = [
        'message',
        'errors' => [
            'email'
        ]
    ];
    protected $passwordInvalidStructure = [
        'message',
        'errors' => [
            'password'
        ]
    ];

    protected function getAdminEmail()
    {
        return env('ADMIN_USER_EMAIL');
    }

    protected function getAdminPassword()
    {
        return env('ADMIN_USER_PASSWORD');
    }

    protected function getAdminUser()
    {
        if (!$this->user) {
            $this->user = User::firstWhere('email', $this->getAdminEmail());
        }

        return $this->user;

    }

    protected function getAdminToken()
    {
        return $this->getAdminUser()->token ?? null;
    }

    protected function getAdminLoginCredentials()
    {
        return ['email' => $this->getAdminEmail(), 'password' => $this->getAdminPassword()];
    }

    protected function getAdminResetPasswordToken()
    {
        if (!$this->userResetPasswordToken) {
            return Password::createToken($this->getAdminUser());
        }

        return $this->userResetPasswordToken;
    }

    protected function generateUniqueEmail()
    {
        return Str::random(15) . '@test.com';
    }
}
