<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

		$table->id('id')->lenght(20);
		$table->string('name',50);
		$table->string('document',11);
		$table->string('email',100);
		$table->string('password',244);
		$table->timestamps();
		$table->datetime('email_verified_at')->nullable();
		$table->datetime('logged_at')->nullable();
		$table->datetime('deleted_at')->nullable();

        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}