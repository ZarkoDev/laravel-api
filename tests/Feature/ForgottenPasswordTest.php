<?php

namespace Tests\Feature;

use Tests\BaseAuthTest;

class ForgottenPasswordTest extends BaseAuthTest
{

    /** @test */
    public function sendNotifySuccessfully()
    {
        $response = $this->postJson(route('password.forgotten'),
            ['email' => $this->getAdminEmail()]
        );

        $response
            ->assertStatus(200)
            ->assertSeeText(__('custom.passwords.sent'));
    }

    /** @test */
    public function emailInvalid()
    {
        $response = $this
            ->postJson(route('password.forgotten'),
            ['email' => static::EMAIL_INVALID]
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
            ->postJson(route('password.forgotten')
        );

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->emailInvalidStructure);
    }

    /** @test */
    public function emailNotExists()
    {
        $response = $this
            ->postJson(route('password.forgotten'),
            ['email' => $this->generateUniqueEmail()]
        );

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->emailInvalidStructure);
    }
}
