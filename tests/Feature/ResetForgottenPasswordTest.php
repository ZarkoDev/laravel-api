<?php

namespace Tests\Feature;

use Tests\BaseAuthTest;

class ResetForgottenPasswordTest extends BaseAuthTest
{
    private $routeName = 'password.reset';

    /** @test */
    public function resetPasswordSuccessfully()
    {
        // reset with the same password
        $response = $this->postJson(route($this->routeName, $this->getAdminResetPasswordToken()),
            ['email' => $this->getAdminEmail(), 'password' => $this->getAdminPassword()]
        );

        $response
            ->assertStatus(static::STATUS_SUCCESS)
            ->assertSeeText(__('custom.password_reset_success'));
    }

    /** @test */
    public function resetWithWrongToken()
    {
        $response = $this->postJson(route($this->routeName, 'bjhasbkjasbk'),
            ['email' => $this->getAdminEmail(), 'password' => $this->getAdminPassword()]
        );

        $response
            ->assertStatus(static::STATUS_BAD_REQUEST)
            ->assertJsonPath('message', __('custom.reset_password_failed'));
    }

    /** @test */
    public function emailInvalid()
    {
        $response = $this->postJson(route($this->routeName, $this->getAdminResetPasswordToken()),
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
        $response = $this->postJson(route($this->routeName, $this->getAdminResetPasswordToken()),
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
        $response = $this->postJson(route($this->routeName, $this->getAdminResetPasswordToken()),
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
        $response = $this->postJson(route($this->routeName, $this->getAdminResetPasswordToken()),
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
        $response = $this->postJson(route($this->routeName, $this->getAdminResetPasswordToken()),
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
        $response = $this->postJson(route($this->routeName, $this->getAdminResetPasswordToken()),
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
        $response = $this->postJson(route($this->routeName, $this->getAdminResetPasswordToken()),
            ['email' => static::EMAIL_INVALID, 'password' => static::PASSWORD_TOO_LONG]
        );

        $response
            ->assertStatus(static::STATUS_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->passwordInvalidStructure);
    }
}
