<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTasksTable extends Migration
{
    public function up()
    {
        Schema::create('user_tasks', function (Blueprint $table) {

		$table->id('id')->length(20);
		$table->bigInteger('user_id',false,true);
		$table->bigInteger('task_id',false,true);
        $table->foreign('task_id')->references('id')->on('tasks');		$table->foreign('user_id')->references('id')->on('users');
        $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_tasks');
    }
}