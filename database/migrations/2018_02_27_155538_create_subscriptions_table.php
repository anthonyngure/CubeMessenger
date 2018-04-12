<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	
	class CreateSubscriptionsTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('subscriptions', function (Blueprint $table) {
				$table->increments('id');
				$table->unsignedInteger('user_id', false);
				$table->foreign('user_id')->references('id')->on('users');
				$table->unsignedInteger('subscription_option_item_id', false);
				$table->foreign('subscription_option_item_id')->references('id')->on('subscription_option_items');
				$table->string('weekdays');
				$table->double('delivery_cost',8,2);
				$table->double('item_cost',8,2);
				$table->boolean('renew_every_month')->default(true);
				$table->date('termination_date')->nullable();
				$table->unsignedMediumInteger('quantity', false);
				$table->enum('status', ['AT_DEPARTMENT_HEAD', 'AT_PURCHASING_HEAD', 'REJECTED', 'EXPIRED', 'ACTIVE'])
					->default('AT_DEPARTMENT_HEAD');
				$table->unsignedInteger('rejected_by_id', false)->nullable();
				$table->foreign('rejected_by_id')->references('id')->on('users');
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
			Schema::dropIfExists('subscriptions');
		}
	}
