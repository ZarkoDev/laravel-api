<?php

namespace Tests;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Str;

abstract class BaseAuthTest extends TestCase
{
    const PASSWORD_DEFAULT = '1a2s3dGG';
    const EMAIL_INVALID = 'test.gmail.com';
    const PASSWORD_INVALID = '123456*';
    const PASSWORD_TOO_LONG = '123456789asdfghjkl';

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

    protected function getAdminToken()
    {
        return User::firstWhere('email', $this->getAdminEmail())->token ?? null;
    }

    protected function getAdminLoginCredentials()
    {
        return ['email' => $this->getAdminEmail(), 'password' => $this->getAdminPassword()];
    }

    protected function generateUniqueEmail()
    {
        return Str::random(15) . '@test.com';
    }
}
