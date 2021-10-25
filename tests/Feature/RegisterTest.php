<?php

namespace Tests\Unit;

use Illuminate\Support\Str;

class RegisterTest extends BaseAuthTest
{

    /** @test */
    public function userCreationSuccess()
    {
        $uniqueEmail = Str::random(15) . '@test.com';

        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route('register'),
                ['email' => $uniqueEmail, 'password' => '123456']
            );

        $response
            ->assertStatus(201)
            ->assertSeeText(__('custom.user_creation_success'));
    }

    /** @test */
    public function tokenFailed()
    {
        $uniqueEmail = Str::random(15) . '@test.com';

        $response = $this
            ->withHeader('Authorization', 'Bearer ' . 123)
            ->postJson(route('register'),
                ['email' => $uniqueEmail, 'password' => '123456']
            );

        $response
            ->assertStatus(401)
            ->assertSeeText(__('custom.not_authorized'));
    }

    /** @test */
    public function tokenMissing()
    {
        $uniqueEmail = Str::random(15) . '@test.com';

        $response = $this
            ->postJson(route('register'),
                ['email' => $uniqueEmail, 'password' => '123456']
            );

        $response
            ->assertStatus(401)
            ->assertSeeText(__('custom.not_authorized'));
    }

    /** @test */
    public function emailInvalid()
    {
        $uniqueEmail = Str::random(15) . 'test.com';

        $response = $this
        ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route('register'),
                ['email' => $uniqueEmail, 'password' => '123456']
            );

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email'
                ]
                ]);
    }

    /** @test */
    public function emailMissing()
    {
        $response = $this
        ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route('register'),
                ['password' => '123456']
            );

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email'
                ]
                ]);
    }

    /** @test */
    public function passwordMissing()
    {
        $uniqueEmail = Str::random(15) . '@test.com';

        $response = $this
        ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route('register'),
                ['email' => $uniqueEmail]
            );

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'password'
                ]
                ]);
    }
}
