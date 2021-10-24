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

        if ($jobTaskService->hasErrors()) {
            return $jobTaskService->getErrorResponse();
        }

        if (!$jobTaskService->runJobTask($task)) {
            return $jobTaskService->getErrorResponse();
        }

        return response('Successfully created task for download company details. You will be notified by email when the task is completed', static::STATUS_CODE_CREATED);
    }
}
