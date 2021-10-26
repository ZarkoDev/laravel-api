<?php

namespace Tests\Feature;

use Tests\BaseAuthTest;

class ChangePasswordTest extends BaseAuthTest
{
    private $routeName = 'password.change';

    /** @test */
    public function changePasswordSuccess()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route($this->routeName),
                ['email' => $this->getAdminEmail(), 'password' => $this->getAdminPassword()]
            );

        $response
            ->assertStatus(static::STATUS_SUCCESS)
            ->assertSeeText(__('custom.change_password_success'));
    }

    /** @test */
    public function tokenFailed()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . 123)
            ->postJson(route($this->routeName),
                ['email' => $this->getAdminEmail(), 'password' => $this->getAdminPassword()]
        );

        $response
            ->assertStatus(static::STATUS_UNAUTHORIZED)
            ->assertSeeText(__('custom.not_authorized'));
    }

    /** @test */
    public function tokenMissing()
    {
        $response = $this
            ->postJson(route('register'),
            ['password' => static::PASSWORD_DEFAULT]
        );

        $response
            ->assertStatus(static::STATUS_UNAUTHORIZED)
            ->assertSeeText(__('custom.not_authorized'));
    }

    /** @test */
    public function passwordMissing()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route($this->routeName));

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
                ['password' => static::PASSWORD_INVALID]
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
                ['password' => '12']
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
                ['password' => static::PASSWORD_TOO_LONG]
            );

        $response
            ->assertStatus(static::STATUS_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->passwordInvalidStructure);
    }
}
