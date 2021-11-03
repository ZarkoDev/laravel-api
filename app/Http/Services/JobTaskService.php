<?php

namespace App\Http\Services;

use App\Exceptions\CreationFailedException;
use App\Exceptions\NotFoundException;
use App\Models\JobTask;

class JobTaskService extends BaseService
{

    public function createDomainTask(array $attributes)
    {
        $task = new JobTask();
        $task->user_id = Auth()->id();
        $task->type = JobTask::TYPE_DOMAIN;
        $task->value = $attributes['domain'];

        if (!$task->save()) {
            throw new CreationFailedException(__('custom.task_creation_failed'), static::STATUS_INTERNAL_SERVER_ERROR);
        }

        return $task;
    }

    public function getTask(array $attributes)
    {
        $task = auth()->user()->jobTasks()->firstWhere(['id' => $attributes['task_id']]);

        if (!$task) {
            throw new NotFoundException(__('custom.task_not_found'), static::STATUS_NOT_FOUND);
        }

        return $task;
    }

    public function getTaskResponse(array $attributes)
    {
        $task = $this->getTask($attributes);

        if (in_array($task->status, [JobTask::STATUS_CREATED, JobTask::STATUS_IN_PROGRESS])) {
            return __('custom.task_not_processed');
        } elseif ($task->response) {
            return $task->response->response;
        }

        return $task->error;
    }
}
