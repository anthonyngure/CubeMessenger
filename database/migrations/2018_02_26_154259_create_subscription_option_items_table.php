<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	
	class CreateSubscriptionOptionItemsTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('subscription_option_items', function (Blueprint $table) {
				$table->increments('id');
				$table->string('name');
				$table->unsignedInteger('subscription_option_id', false)->nullable();
				$table->foreign('subscription_option_id')->references('id')->on('subscription_options');
				$table->unsignedSmallInteger('price')
					->comment('Current retail price of the item');
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
			Schema::dropIfExists('subscription_option_items');
		}
	}
