<?php

namespace Tests\Feature;

use Tests\BaseAuthTest;

class CompanyDownloadTest extends BaseAuthTest
{
    private $routeName = 'company.downloadDetails';
    private $domainNameValid = 'segment.com';
    private $domainNameInvalid = 'testttgg';
    private $domainInvalidStructure = [
        'message',
        'errors' => [
            'domain'
        ]
    ];

    /** @test */
    public function createCompanyDomainTaskSuccessfully()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route($this->routeName),
                ['domain' => $this->domainNameValid]
            );

        $response
            ->assertStatus(static::STATUS_CREATED)
            ->assertSeeText(__('custom.task_created_successfully'));
    }

    /** @test */
    public function tokenFailed()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . 123)
            ->postJson(route($this->routeName),
                ['domain' => $this->domainNameValid]
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
            ['domain' => $this->domainNameValid]
        );

        $response
            ->assertStatus(static::STATUS_UNAUTHORIZED)
            ->assertSeeText(__('custom.not_authorized'));
    }

    /** @test */
    public function domainMissing()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route($this->routeName));

        $response
            ->assertStatus(static::STATUS_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->domainInvalidStructure);
    }

    /** @test */
    public function domainInvalid()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route($this->routeName),
                ['domain' => $this->domainNameInvalid]
            );

        $response
            ->assertStatus(static::STATUS_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->domainInvalidStructure);
    }
}
