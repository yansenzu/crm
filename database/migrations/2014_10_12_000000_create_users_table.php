<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table){
            $table->id('hondaid');
            $table->string('namapic');
            $table->string('password');
            $table->string('tempatlahir');
            $table->date('tgllahir');
            $table->string('jabatan');
            $table->string('status');
            $table->string('dealer');
            $table->string('class');
            $table->text('remember_token')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('created_at')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
