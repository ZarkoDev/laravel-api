<?php

namespace Tests\Feature;

use Tests\BaseAuthTest;

class RegisterTest extends BaseAuthTest
{
    private $routeName = 'register';
    private $uniqueEmail;

    public function __construct()
    {
        parent::__construct();

        $this->uniqueEmail = $this->generateUniqueEmail();
    }

    /** @test */
    public function userCreationSuccess()
    {
        $uniqueEmail = $this->generateUniqueEmail();

        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route($this->routeName),
                ['email' => $uniqueEmail, 'password' => static::PASSWORD_DEFAULT]
            );

        $response
            ->assertStatus(static::STATUS_CREATED)
            ->assertSeeText(__('custom.user_creation_success'));
    }

    /** @test */
    public function tokenFailed()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . 123)
            ->postJson(route($this->routeName),
                ['email' => $this->uniqueEmail, 'password' => static::PASSWORD_DEFAULT]
            );

        $response
            ->assertStatus(static::STATUS_UNAUTHORIZED)
            ->assertSeeText(__('custom.not_authorized'));
    }

    /** @test */
    public function tokenMissing()
    {
        $response = $this
            ->postJson(route($this->routeName),
            ['email' => $this->uniqueEmail, 'password' => static::PASSWORD_DEFAULT]
        );

        $response
            ->assertStatus(static::STATUS_UNAUTHORIZED)
            ->assertSeeText(__('custom.not_authorized'));
    }

    /** @test */
    public function emailInvalid()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
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
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route($this->routeName),
                ['password' => static::PASSWORD_DEFAULT]
            );

        $response
            ->assertStatus(static::STATUS_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->emailInvalidStructure);
    }

    /** @test */
    public function emailAlreadyExists()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route($this->routeName),
                ['email' => env('ADMIN_USER_EMAIL'), 'password' => static::PASSWORD_DEFAULT]
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
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route($this->routeName),
                ['email' => $this->uniqueEmail]
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
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route($this->routeName),
                ['email' => $this->uniqueEmail, 'password' => static::PASSWORD_INVALID]
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
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route($this->routeName),
                ['email' => $this->uniqueEmail, 'password' => '12']
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
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route($this->routeName),
                ['email' => $this->uniqueEmail, 'password' => static::PASSWORD_TOO_LONG]
            );

        $response
            ->assertStatus(static::STATUS_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->passwordInvalidStructure);
    }
}
