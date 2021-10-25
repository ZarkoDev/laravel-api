<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

abstract class BaseAuthTest extends TestCase
{
    public function getAdminToken()
    {
        return User::firstWhere('email', env('ADMIN_USER_EMAIL'))->token ?? null;
    }
}
