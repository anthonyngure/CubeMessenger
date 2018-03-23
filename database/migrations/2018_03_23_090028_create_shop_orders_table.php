<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	
	class CreateShopOrdersTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('shop_orders', function (Blueprint $table) {
				$table->increments('id');
				$table->unsignedInteger('client_id', false);
				$table->foreign('client_id')->references('id')->on('clients');
				$table->unsignedInteger('shop_product_id', false);
				$table->foreign('shop_product_id')->references('id')->on('shop_products');
				$table->unsignedInteger('quantity', false);
				$table->enum('status', ['NEW', 'CONFIRMED', 'DELIVERED'])->default('NEW');
				$table->timestamp('confirmed_at')->nullable();
				$table->timestamp('delivered_at')->nullable();
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
			Schema::dropIfExists('shop_orders');
		}
	}
