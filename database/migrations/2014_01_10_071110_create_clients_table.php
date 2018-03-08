<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
	        $table->increments('id');
	        $table->string('name');
	        $table->string('logo')->default('clients/default.png');
	        $table->string('email')->unique();
	        $table->string('phone')->unique();
	        $table->double('latitude', 8, 5);
	        $table->double('longitude', 8, 5);
	        $table->string('primary_color');
	        $table->string('accent_color');
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
        Schema::dropIfExists('clients');
    }
}
