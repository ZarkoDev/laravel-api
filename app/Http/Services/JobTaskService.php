<?php

namespace App\Http\Services;

use App\Exceptions\CreationFailedException;
use App\Exceptions\JobTaskException;
use App\Exceptions\NotFoundException;
use App\Models\JobTask;
use App\Jobs\DownloadCompanyDetails;

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

    public function runJobTask(JobTask $task)
    {
        switch ($task->type) {
            case JobTask::TYPE_DOMAIN:
                return DownloadCompanyDetails::dispatch($task)->onQueue('tasks');
            default:
                throw new JobTaskException(__('custom.task_type_unknown'), static::STATUS_BAD_REQUEST);
        }
    }

    public function getTaskResponse(array $attributes)
    {
        $task = JobTask::where('id', $attributes['task_id'])
            ->where('user_id', Auth()->id())
            ->with('response')
            ->first();

        if (!$task) {
            throw new NotFoundException(__('custom.task_not_found'), static::STATUS_NOT_FOUND);
        }

        if ($task->response) {
            return $task->response->response;
        }

        return $task->error;
    }
}
