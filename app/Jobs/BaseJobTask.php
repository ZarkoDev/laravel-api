<?php

namespace App\Jobs;

use App\Models\JobTask;
use App\Notifications\JobTaskNotification;

abstract class BaseJobTask
{
    abstract protected function executeTask();
    abstract public function handle();

    protected function isValidTask()
    {
        if (!$this->task) {
            $this->setTaskError('Not found task');
            return false;
        }
    }

    protected function setTaskError($message)
    {
        $this->task->status = JobTask::STATUS_FAILED;
        $this->task->error = $message;
    }

    protected function startTask()
    {
        $this->task->status = JobTask::STATUS_IN_PROGRESS;
        $this->task->save();
        // eventually notify the user that the task is started
    }

    protected function completeTask()
    {
        $notifiedStatus = $this->notifyUser();
        $this->task->is_notified = $notifiedStatus;
        $this->task->save();
    }

    protected function notifyUser()
    {
        if (!$this->isValidUser()) {
            return false;
        }
        
        $this->task->user->notify(new JobTaskNotification($this->task));

        return true;
    }

    protected function isValidUser()
    {
        if (is_null($this->task->user_id)) {
            $this->setTaskError('Missing user');
            return false;
        }

        if (!$this->task->user) {
            $this->setTaskError('User not found');
            return false;
        }

        if ($this->task->user->hasValidEmail()) {
            $this->setTaskError('User email is invalid');
            return false;
        }

        return true;
    }
}
