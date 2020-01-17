<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Invite;

class CreateInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
        public function up()
    {
        Schema::create('invites', function (Blueprint $table) {
            $table->increments('invite_Id');
            $table->integer('event_Id');
            $table->string('email');
            $table->string('token', 16)->unique();
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::drop('invites');
    }
}
