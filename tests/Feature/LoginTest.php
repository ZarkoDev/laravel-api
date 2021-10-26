<?php

namespace Tests\Feature;

use Tests\BaseAuthTest;

class LoginTest extends BaseAuthTest
{
    private $routeName = 'login';

    /** @test */
    public function loginSuccess()
    {
        $response = $this->postJson(route($this->routeName),
            $this->getAdminLoginCredentials()
        );

        $response
            ->assertStatus(static::STATUS_SUCCESS)
            ->assertJsonPath('data.email', env('ADMIN_USER_EMAIL'))
            ->assertJsonPath('data.token', $this->getAdminToken());
    }

    /** @test */
    public function loginWithWrongPassword()
    {
        $response = $this->postJson(route($this->routeName),
            ['email' => $this->getAdminEmail(), 'password' => 'wrongpass']
        );

        $response
            ->assertStatus(static::STATUS_NOT_FOUND)
            ->assertJsonPath('message', __('custom.user_not_found'));
    }

    /** @test */
    public function emailInvalid()
    {
        $response = $this
            ->postJson(route($this->routeName),
            ['email' => static::EMAIL_INVALID, 'password' => static::PASSWORD_DEFAULT]
        );

        $response
            ->assertStatus(static::STATUS_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->emailInvalidStructure);
    }


    /** @test */
    public function emailMissing()
    {
        $response = $this
            ->postJson(route($this->routeName),
            ['password' => static::PASSWORD_DEFAULT]
        );

        $response
            ->assertStatus(static::STATUS_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->emailInvalidStructure);
    }

    /** @test */
    public function emailNotExists()
    {
        $response = $this
            ->postJson(route($this->routeName),
            ['email' => $this->generateUniqueEmail(), 'password' => static::PASSWORD_DEFAULT]
        );

        $response
            ->assertStatus(static::STATUS_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->emailInvalidStructure);
    }

    /** @test */
    public function passwordMissing()
    {
        $response = $this
            ->postJson(route($this->routeName),
            ['email' => static::EMAIL_INVALID]
        );

        $response
            ->assertStatus(static::STATUS_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->passwordInvalidStructure);
    }

    /** @test */
    public function passwordNotAlphaNum()
    {
        $response = $this
            ->postJson(route($this->routeName),
            ['email' => static::EMAIL_INVALID, 'password' => static::PASSWORD_INVALID]
        );

        $response
            ->assertStatus(static::STATUS_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->passwordInvalidStructure);
    }

    /** @test */
    public function passwordTooWeak()
    {
        $response = $this
            ->postJson(route($this->routeName),
            ['email' => static::EMAIL_INVALID, 'password' => '12']
        );

        $response
            ->assertStatus(static::STATUS_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->passwordInvalidStructure);
    }

    /** @test */
    public function passwordTooLong()
    {
        $response = $this
            ->postJson(route($this->routeName),
            ['email' => static::EMAIL_INVALID, 'password' => static::PASSWORD_TOO_LONG]
        );

        $response
            ->assertStatus(static::STATUS_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->passwordInvalidStructure);
    }
}
