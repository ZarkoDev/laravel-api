<?php

namespace Tests\Feature;

use Tests\BaseAuthTest;

class ResetForgottenPasswordTest extends BaseAuthTest
{

    /** @test */
    public function resetPasswordSuccessfully()
    {
        // reset with the same password
        $response = $this->postJson(route('password.reset', $this->getAdminResetPasswordToken()),
            ['email' => $this->getAdminEmail(), 'password' => $this->getAdminPassword()]
        );

        $response
            ->assertStatus(200)
            ->assertSeeText(__('custom.password_reset_success'));
    }

    /** @test */
    public function resetWithWrongToken()
    {
        $response = $this->postJson(route('password.reset', 'bjhasbkjasbk'),
            ['email' => $this->getAdminEmail(), 'password' => $this->getAdminPassword()]
        );

        $response
            ->assertStatus(400)
            ->assertJsonPath('message', __('custom.reset_password_failed'));
    }

    /** @test */
    public function emailInvalid()
    {
        $response = $this->postJson(route('password.reset', $this->getAdminResetPasswordToken()),
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
        $response = $this->postJson(route('password.reset', $this->getAdminResetPasswordToken()),
            ['password' => static::PASSWORD_DEFAULT]
        );

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->emailInvalidStructure);
    }

    /** @test */
    public function emailNotExists()
    {
        $response = $this->postJson(route('password.reset', $this->getAdminResetPasswordToken()),
            ['email' => $this->generateUniqueEmail(), 'password' => static::PASSWORD_DEFAULT]
        );

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->emailInvalidStructure);
    }

    /** @test */
    public function passwordMissing()
    {
        $response = $this->postJson(route('password.reset', $this->getAdminResetPasswordToken()),
            ['email' => static::EMAIL_INVALID]
        );

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->passwordInvalidStructure);
    }

    /** @test */
    public function passwordNotAlphaNum()
    {
        $response = $this->postJson(route('password.reset', $this->getAdminResetPasswordToken()),
            ['email' => static::EMAIL_INVALID, 'password' => static::PASSWORD_INVALID]
        );

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->passwordInvalidStructure);
    }

    /** @test */
    public function passwordTooWeak()
    {
        $response = $this->postJson(route('password.reset', $this->getAdminResetPasswordToken()),
            ['email' => static::EMAIL_INVALID, 'password' => '12']
        );

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->passwordInvalidStructure);
    }

    /** @test */
    public function passwordTooLong()
    {
        $response = $this->postJson(route('password.reset', $this->getAdminResetPasswordToken()),
            ['email' => static::EMAIL_INVALID, 'password' => static::PASSWORD_TOO_LONG]
        );

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->passwordInvalidStructure);
    }
}
