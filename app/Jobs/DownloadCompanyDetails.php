<?php

namespace App\Jobs;

use App\Models\JobTask;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DownloadCompanyDetails extends JobTaskBasic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $task;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(JobTask $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach (range(1, 10) as $item) {
            info("TestOne: item #" . $this->task->domain);
        }

        $this->task->status = JobTask::STATUS_SUCCESS;
        $this->task->save();

        $this->notifyUser();
    }
}
