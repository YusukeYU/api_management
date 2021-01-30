<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {

		$table->id('id')->length(20);
		$table->string('name',50);
        $table->string('document',15);
        $table->timestamps();
        $table->string('client_type',30)->nullable();
        $table->string('details',100)->nullable();
        $table->timestamp('deleted_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
}