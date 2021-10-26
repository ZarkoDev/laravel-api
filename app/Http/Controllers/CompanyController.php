<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Http\Services\JobTaskService;

class CompanyController extends Controller
{

    public function downloadCompanyDetails(CompanyRequest $request, JobTaskService $jobTaskService)
    {
        $attributes = $request->validated();
        $task = $jobTaskService->createDomainTask($attributes);

        if (!$jobTaskService->runJobTask($task)) {
            return $jobTaskService->getErrorResponse();
        }

        return response(__('custom.task_created_successfully'), static::STATUS_CODE_CREATED);
    }
}
