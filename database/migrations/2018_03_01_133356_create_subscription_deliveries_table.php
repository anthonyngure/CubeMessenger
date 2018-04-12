<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	
	class CreateSubscriptionDeliveriesTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('subscription_deliveries', function (Blueprint $table) {
				$table->increments('id');
				$table->unsignedInteger('subscription_id', false);
				$table->foreign('subscription_id')->references('id')->on('subscriptions');
				$table->unsignedInteger('received_by_id', false);
				$table->foreign('received_by_id')->references('id')->on('users');
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
			Schema::dropIfExists('subscription_deliveries');
		}
	}
