<?php

namespace Tests\Unit;

use Tests\TestCase;

class RegisterTest extends TestCase
{

    public function test()
    {
        $response = $this->postJson(route('register'),
            ['email' => 'test6@gmail.com', 'password' => '123456']
        );

        $response
            ->assertStatus(201)
            ->assertSeeText('Successfully created user');
    }
}
