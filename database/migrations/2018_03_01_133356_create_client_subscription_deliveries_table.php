<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	
	class CreateClientSubscriptionDeliveriesTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('client_subscription_deliveries', function (Blueprint $table) {
				$table->increments('id');
				$table->unsignedInteger('client_subscription_id', false)->nullable();
				$table->foreign('client_subscription_id')->references('id')->on('client_subscriptions');
				$table->unsignedSmallInteger('item_cost')
					->comment('Retail price of the item at the time of delivery');
				$table->unsignedSmallInteger('delivery_cost')
					->comment('includes delivery base cost of the item and cost based on distance');
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
			Schema::dropIfExists('client_subscription_deliveries');
		}
	}
