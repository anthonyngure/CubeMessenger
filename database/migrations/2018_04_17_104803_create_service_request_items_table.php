<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceRequestItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_request_items', function (Blueprint $table) {
            $table->increments('id');
	        $table->unsignedInteger('service_request_quote_id', false);
	        $table->foreign('service_request_quote_id')->references('id')->on('service_request_quotes');
            $table->string('name');
            $table->double('price', 8, 2);
	        $table->string('note')->nullable();
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
        Schema::dropIfExists('service_request_items');
    }
}
