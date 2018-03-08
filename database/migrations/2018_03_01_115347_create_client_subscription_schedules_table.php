<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientSubscriptionSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_subscription_schedules', function (Blueprint $table) {
            $table->increments('id');
	        $table->unsignedInteger('client_subscription_id', false)->nullable();
	        $table->foreign('client_subscription_id')->references('id')->on('client_subscriptions');
	        $table->unsignedInteger('subscription_schedule_id', false)->nullable();
	        $table->foreign('subscription_schedule_id')->references('id')->on('subscription_schedules');
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
        Schema::dropIfExists('client_subscription_schedules');
    }
}
