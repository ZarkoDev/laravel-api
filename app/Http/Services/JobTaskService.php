<?php

namespace App\Http\Services;

use App\Http\Traits\ErrorTrait;
use App\Models\JobTask;
use App\Jobs\DownloadCompanyDetails;

class JobTaskService
{
    use ErrorTrait;

    public function createDomainTask(array $attributes)
    {
        $task = new JobTask();
        $task->user_id = Auth()->id();
        $task->type = JobTask::TYPE_DOMAIN;
        $task->value = $attributes['domain'];

        if (!$task->save()) {
            $this->setError('Unsuccessfully created task');
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
                $this->setError('Task type is unknown');
                return false;
        }
    }
}
