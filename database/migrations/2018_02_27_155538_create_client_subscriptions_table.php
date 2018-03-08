<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_subscriptions', function (Blueprint $table) {
            $table->increments('id');
	        $table->unsignedInteger('client_id', false)->nullable();
	        $table->foreign('client_id')->references('id')->on('users');
	        $table->unsignedInteger('subscription_item_id', false)->nullable();
	        $table->foreign('subscription_item_id')->references('id')->on('subscription_items');
	        $table->unsignedSmallInteger('quantity', false);
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
        Schema::dropIfExists('client_subscriptions');
    }
}
