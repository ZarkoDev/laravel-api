<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Services\JobTaskService;

class TaskController extends Controller
{

    public function getTaskResponse(TaskRequest $request, JobTaskService $jobTaskService)
    {
        $attributes = $request->validated();
        $taskResponse = $jobTaskService->getTaskResponse($attributes);

        if ($jobTaskService->hasErrors()) {
            return $jobTaskService->getErrorResponse();
        }

        return response($taskResponse, 200, ['content-type' => 'application/json']);
    }
}
