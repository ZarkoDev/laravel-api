<?php

use App\Models\JobTask;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobTaskResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_task_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(JobTask::class, 'job_task_id')->unsigned()->index();
            $table->unsignedSmallInteger('status_code');
            $table->text('response');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_task_responses');
    }
}
