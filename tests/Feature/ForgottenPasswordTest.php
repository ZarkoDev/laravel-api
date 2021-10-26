<?php

namespace Tests\Feature;

use Tests\BaseAuthTest;

class ForgottenPasswordTest extends BaseAuthTest
{
    private $routeName = 'password.forgotten';

    /** @test */
    public function sendNotifySuccessfully()
    {
        $response = $this->postJson(route($this->routeName),
            ['email' => $this->getAdminEmail()]
        );

        $response
            ->assertStatus(static::STATUS_SUCCESS)
            ->assertSeeText(__('custom.passwords.sent'));
    }

    /** @test */
    public function emailInvalid()
    {
        $response = $this
            ->postJson(route($this->routeName),
            ['email' => static::EMAIL_INVALID]
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
            ->postJson(route($this->routeName)
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
            ['email' => $this->generateUniqueEmail()]
        );

        $response
            ->assertStatus(static::STATUS_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->emailInvalidStructure);
    }
}
