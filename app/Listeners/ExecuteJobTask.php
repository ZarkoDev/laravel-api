<?php

namespace App\Listeners;

use App\Events\JobTaskCreated;
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
                DownloadCompanyDetails::dispatch($event->jobTask);
                break;
            default:
                $event->jobTask->status = JobTask::STATUS_FAILED;
                $event->jobTask->error = __('custom.task_type_unknown');
                $event->jobTask->save();
                break;
        }
    }
}
