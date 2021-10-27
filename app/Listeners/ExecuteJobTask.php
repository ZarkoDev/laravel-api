<?php

namespace App\Listeners;

use App\Events\JobTaskCreated;
use App\Exceptions\JobTaskException;
use App\Jobs\DownloadCompanyDetails;
use App\Models\JobTask;
use Illuminate\Contracts\Queue\ShouldQueue;

class ExecuteJobTask implements ShouldQueue
{
    public function __construct()
    {
        //
    }

    public function handle(JobTaskCreated $event)
    {
        switch ($event->jobTask->type) {
            case JobTask::TYPE_DOMAIN:
                return DownloadCompanyDetails::dispatch($event->jobTask);
            default:
                throw new JobTaskException(__('custom.task_type_unknown'), 400);
        }
    }
}
