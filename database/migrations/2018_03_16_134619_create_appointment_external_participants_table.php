<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentExternalParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment_external_participants', function (Blueprint $table) {
            $table->increments('id');
	        $table->unsignedInteger('appointment_id', false);
	        $table->foreign('appointment_id')->references('id')->on('appointments');
	        $table->string('name');
	        $table->string('email');
	        $table->string('phone');
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
        Schema::dropIfExists('appointment_external_participants');
    }
}
