<?php

namespace Tests\Feature;

use Tests\BaseAuthTest;

class RegisterTest extends BaseAuthTest
{
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
            ->postJson(route('register'),
                ['email' => $uniqueEmail, 'password' => static::PASSWORD_DEFAULT]
            );

        $response
            ->assertStatus(201)
            ->assertSeeText(__('custom.user_creation_success'));
    }

    /** @test */
    public function tokenFailed()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . 123)
            ->postJson(route('register'),
                ['email' => $this->uniqueEmail, 'password' => static::PASSWORD_DEFAULT]
            );

        $response
            ->assertStatus(401)
            ->assertSeeText(__('custom.not_authorized'));
    }

    /** @test */
    public function tokenMissing()
    {
        $response = $this
            ->postJson(route('register'),
            ['email' => $this->uniqueEmail, 'password' => static::PASSWORD_DEFAULT]
        );

        $response
            ->assertStatus(401)
            ->assertSeeText(__('custom.not_authorized'));
    }

    /** @test */
    public function emailInvalid()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route('register'),
                ['email' => static::EMAIL_INVALID, 'password' => static::PASSWORD_DEFAULT]
            );

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->emailInvalidStructure);
    }

    /** @test */
    public function emailMissing()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route('register'),
                ['password' => static::PASSWORD_DEFAULT]
            );

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->emailInvalidStructure);
    }

    /** @test */
    public function emailAlreadyExists()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route('register'),
                ['email' => env('ADMIN_USER_EMAIL'), 'password' => static::PASSWORD_DEFAULT]
            );

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->emailInvalidStructure);
    }

    /** @test */
    public function passwordMissing()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route('register'),
                ['email' => $this->uniqueEmail]
            );

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->passwordInvalidStructure);
    }

    /** @test */
    public function passwordNotAlphaNum()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route('register'),
                ['email' => $this->uniqueEmail, 'password' => static::PASSWORD_INVALID]
            );

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->passwordInvalidStructure);
    }

    /** @test */
    public function passwordTooWeak()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route('register'),
                ['email' => $this->uniqueEmail, 'password' => '12']
            );

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->passwordInvalidStructure);
    }

    /** @test */
    public function passwordTooLong()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route('register'),
                ['email' => $this->uniqueEmail, 'password' => static::PASSWORD_TOO_LONG]
            );

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->passwordInvalidStructure);
    }
}
