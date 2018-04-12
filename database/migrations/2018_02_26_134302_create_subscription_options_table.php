<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
	        $table->unsignedSmallInteger('delivery_cost')->comment('Base cost for delivering the item to the client');
	        $table->string('description')->nullable();
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
        Schema::dropIfExists('subscription_options');
    }
}
