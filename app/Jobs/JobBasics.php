<?php

namespace App\Jobs;

use App\Models\JobTask;

abstract class JobTaskBasic
{
    protected function notifyUser()
    {
        if (is_null($this->task->user_id)) {
            return false;
        }

        if (!$this->task->user) {
            return false;
        }

        if ($this->task->isFailed()) {
            // notify with error message
        }

        // notify with generated link (task_id) to check his task response
    }
}
