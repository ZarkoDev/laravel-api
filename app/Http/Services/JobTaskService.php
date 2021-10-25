<?php

namespace App\Http\Services;

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
            $this->setError(__('custom.task_creation_failed'), static::STATUS_INTERNAL_SERVER_ERROR);
            return false;
        }

        return $task;
    }

    public function runJobTask(JobTask $task)
    {
        switch ($task->type) {
            case JobTask::TYPE_DOMAIN:
                return DownloadCompanyDetails::dispatch($task)->onQueue('tasks');
            default:
                $this->setError(__('custom.task_type_unknown'), static::STATUS_BAD_REQUEST);
                return false;
        }
    }

    public function getTaskResponse(array $attributes)
    {
        $task = JobTask::where('id', $attributes['task_id'])
            ->where('user_id', Auth()->id())
            ->with('response')
            ->first();

        if (!$task) {
            $this->setError(__('custom.task_not_found'), static::STATUS_NOT_FOUND);
        }

        if ($task->response) {
            return $task->response->response;
        }

        return $task->error;
    }
}
