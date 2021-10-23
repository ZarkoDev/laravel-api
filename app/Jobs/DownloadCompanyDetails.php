<?php

namespace App\Jobs;

use App\Http\Services\ClearbitApiService;
use App\Models\JobTask;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DownloadCompanyDetails extends BaseJobTask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $task;
    protected $clearbitApiService;

    public function __construct(JobTask $task)
    {
        $this->task = $task;
        $this->clearbitApiService = new ClearbitApiService();
    }

    public function handle()
    {
        if (!$this->isValidTask()) {
            $this->completeTask();
            return;
        }

        try {
            $this->startTask();
            $this->executeTask();
        } catch (Exception $ex) {
            $this->setTaskError($ex->getMessage());
        }

        $this->completeTask();
    }

    protected function isValidTask()
    {
        parent::isValidTask();

        if ($this->task->type !== JobTask::TYPE_DOMAIN) {
            $this->setTaskError('Something is wrong with task type');
            return false;
        }

        if (empty($this->task->value)) {
            $this->setTaskError('Domain is missing');
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
