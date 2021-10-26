<?php

namespace Tests;

use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

abstract class BaseAuthTest extends TestCase
{
    const PASSWORD_DEFAULT = '1a2s3dGG';
    const EMAIL_INVALID = 'test.gmail.com';
    const PASSWORD_INVALID = '123456*';
    const PASSWORD_TOO_LONG = '123456789asdfghjkl';

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
        return User::firstWhere('email', $this->getAdminEmail());
    }

    protected function getAdminToken()
    {
        if (!$this->user) {
            return $this->getAdminUser()->token ?? null;
        }

        return $this->user;
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
