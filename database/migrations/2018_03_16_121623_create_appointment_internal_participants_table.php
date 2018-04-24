<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentInternalParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_internal_participants', function (Blueprint $table) {
            $table->increments('id');
	        $table->unsignedInteger('user_id', false);
	        $table->foreign('user_id')->references('id')->on('users');
	        $table->unsignedInteger('appointment_id', false);
	        $table->foreign('appointment_id')->references('id')->on('appointments');
            $table->timestamps();
	        $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointment_internal_participants');
    }
}
