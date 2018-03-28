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
				$table->unsignedInteger('user_id', false);
				$table->foreign('user_id')->references('id')->on('users');
				$table->unsignedInteger('shop_product_id', false);
				$table->foreign('shop_product_id')->references('id')->on('shop_products');
				$table->unsignedInteger('quantity', false);
				$table->enum('status', ['AT_DEPARTMENT_HEAD', 'AT_PURCHASING_HEAD', 'REJECTED',
					'PENDING_DELIVERY', 'DELIVERED'])->default('AT_DEPARTMENT_HEAD');
				$table->timestamp('department_head_approved_at')->nullable();
				$table->timestamp('purchasing_head_approved_at')->nullable();
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
