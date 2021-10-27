<?php

namespace App\Http\Controllers;

use App\Events\JobTaskCreated;
use App\Http\Requests\CompanyRequest;
use App\Http\Services\JobTaskService;

class CompanyController extends Controller
{

    public function downloadCompanyDetails(CompanyRequest $request, JobTaskService $jobTaskService)
    {
        $attributes = $request->validated();
        $jobTask = $jobTaskService->createDomainTask($attributes);
        event(new JobTaskCreated($jobTask));

        return response(__('custom.task_created_successfully'), static::STATUS_CODE_CREATED);
    }
}
