<?php

use App\Models\JobTask;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id')->unsigned();
            $table->tinyInteger('type')->unsigned();
            $table->string('value');
            $table->unsignedTinyInteger('status')->default(JobTask::STATUS_CREATED);
            $table->string('error')->nullable();
            $table->boolean('is_notified')->default(false);
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
        Schema::dropIfExists('job_tasks');
    }
}
