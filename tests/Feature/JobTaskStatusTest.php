<?php

namespace Tests\Feature;

use App\Exceptions\NotFoundException;
use App\Models\JobTask;
use Tests\BaseAuthTest;

class JobTaskStatusTest extends BaseAuthTest
{
    private $routeName = 'task.status';
    private $jobTask;
    private $taskInvalidStructure = [
        'message',
        'errors' => [
            'task_id'
        ]
    ];

    /** @test */
    public function getTaskStatusSuccess()
    {
        $this->getLastAdminJobTask();

        if (!$this->jobTask) {
            throw new NotFoundException(__('custom.task_not_found'), static::STATUS_NOT_FOUND);
        }

        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route($this->routeName),
                ['task_id' => $this->jobTask->id]
            );

        $response
            ->assertStatus(static::STATUS_SUCCESS)
            ->assertJsonPath('data.status', $this->jobTask->getStatusName());
    }

    /**
     * @test
     * The test will work if there is another user and himself task
     * */
    public function taskBelongsToSomeoneElse()
    {
        $task = $this->getLastNotAdminJobTask();

        if (!$task) {
            $this->assertTrue(true);
            return;
        }

        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route($this->routeName),
                ['task_id' => $task->id]
            );

        $response
            ->assertStatus(static::STATUS_NOT_FOUND)
            ->assertJsonPath('message', __('custom.task_not_found'));
    }

    /** @test */
    public function tokenFailed()
    {
        $this->getLastAdminJobTask();

        if (!$this->jobTask) {
            throw new NotFoundException(__('custom.task_not_found'), static::STATUS_NOT_FOUND);
        }

        $response = $this
            ->withHeader('Authorization', 'Bearer ' . 123)
            ->postJson(route($this->routeName),
                ['task_id' => $this->jobTask->id]
            );

        $response
            ->assertStatus(static::STATUS_UNAUTHORIZED)
            ->assertSeeText(__('custom.not_authorized'));
    }

    /** @test */
    public function tokenMissing()
    {
        $this->getLastAdminJobTask();

        if (!$this->jobTask) {
            throw new NotFoundException(__('custom.task_not_found'), static::STATUS_NOT_FOUND);
        }

        $response = $this
            ->postJson(route($this->routeName),
                ['task_id' => $this->jobTask->id]
            );

        $response
            ->assertStatus(static::STATUS_UNAUTHORIZED)
            ->assertSeeText(__('custom.not_authorized'));
    }

    /** @test */
    public function taskNotInteger()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route($this->routeName),
                ['task_id' => 'abc']
            );

        $response
            ->assertStatus(static::STATUS_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->taskInvalidStructure);
    }

    /** @test */
    public function taskNotFound()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route($this->routeName),
                ['task_id' => 9999] // can be taken last id and increment it
            );

        $response
            ->assertStatus(static::STATUS_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->taskInvalidStructure);
    }

    /** @test */
    public function taskMissing()
    {
        $response = $this
            ->withHeader('Authorization', 'Bearer ' . $this->getAdminToken())
            ->postJson(route($this->routeName));

        $response
            ->assertStatus(static::STATUS_UNPROCESSABLE_ENTITY)
            ->assertJsonPath('message', __('custom.invalid_data'))
            ->assertJsonStructure($this->taskInvalidStructure);
    }

    private function getLastAdminJobTask()
    {
        if (!$this->jobTask) {
            $adminUser = $this->getAdminUser();
            $this->jobTask = $adminUser->jobTasks()->latest()->first();
        }

        return $this->jobTask;
    }

    private function getLastNotAdminJobTask()
    {
        $adminUser = $this->getAdminUser();
        return JobTask::firstWhere('user_id', '!=', $adminUser->id);
    }
}
