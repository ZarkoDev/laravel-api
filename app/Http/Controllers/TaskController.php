<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\JobTaskStatusResource;
use App\Http\Services\JobTaskService;

class TaskController extends Controller
{

    public function getTaskStatus(TaskRequest $request, JobTaskService $jobTaskService)
    {
        $attributes = $request->validated();
        $task = $jobTaskService->getTask($attributes);

        return new JobTaskStatusResource($task);
    }

    public function getTaskResponse(TaskRequest $request, JobTaskService $jobTaskService)
    {
        $attributes = $request->validated();
        $taskResponse = $jobTaskService->getTaskResponse($attributes);

        return response($taskResponse, 200, ['content-type' => 'application/json']);
    }
}
