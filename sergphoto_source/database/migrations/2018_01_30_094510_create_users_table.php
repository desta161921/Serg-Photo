<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_Id');
            $table->string('first_Name');
            $table->string('last_Name');
            $table->string('gender')->nullable();
            $table->date('DOB')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar')->default("default-avatar.png");
            $table->string('profession')->nullable()->default("School of life");
            $table->string('location')->nullable()->default("Around the world");
            $table->string('hobby')->nullable();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
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
