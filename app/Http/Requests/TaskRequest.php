<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{

    public function rules()
    {
        return [
            'task_id'    => 'required|integer|exists:job_tasks,id'
        ];
    }

    public function messages()
    {
        return [
            'task_id.exists' => __('custom.task_not_found'),
        ];
    }
}
