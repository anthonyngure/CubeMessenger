<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	
	class CreateSubscriptionItemsTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('subscription_items', function (Blueprint $table) {
				$table->increments('id');
				$table->string('name');
				$table->unsignedInteger('subscription_type_id', false)->nullable();
				$table->foreign('subscription_type_id')->references('id')->on('subscription_types');
				$table->unsignedSmallInteger('item_cost')
					->comment('Current retail price of the item');
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
			Schema::dropIfExists('subscription_items');
		}
	}
