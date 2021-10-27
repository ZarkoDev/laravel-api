<?php

namespace App\Jobs;

use App\Http\Services\ClearbitApiService;
use App\Models\JobTask;

class DownloadCompanyDetails extends BaseJobTask
{
    protected $clearbitApiService;

    public function __construct(JobTask $task)
    {
        parent::__construct($task);

        $this->clearbitApiService = new ClearbitApiService();
    }

    protected function isValidTask()
    {
        parent::isValidTask();

        if ($this->task->type !== JobTask::TYPE_DOMAIN) {
            $this->setTaskError(__('custom.job_task_type_wrong'));
            return false;
        }

        if (empty($this->task->value)) {
            $this->setTaskError(__('custom.domain_missing'));
            return false;
        }

        return true;
    }

    protected function executeTask()
    {
        $this->clearbitApiService->downloadCompanyDetails($this->task->value);

        $this->task->response()->create([
            'status_code' => $this->clearbitApiService->getHttpStatusCode(),
            'response' => $this->clearbitApiService->getResponseBody()->toJson()
        ]);

        if ($this->clearbitApiService->isResponseFailed()) {
            $this->setTaskError($this->clearbitApiService->getResponseErrorMessage());
            return;
        }

        $this->task->status = JobTask::STATUS_SUCCESS;
    }
}
