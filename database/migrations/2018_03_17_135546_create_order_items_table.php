<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	
	class CreateOrderItemsTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('order_items', function (Blueprint $table) {
				$table->increments('id');
				$table->unsignedInteger('order_id', false);
				$table->foreign('order_id')->references('id')->on('orders');
				$table->unsignedInteger('product_id', false);
				$table->foreign('product_id')->references('id')->on('products');
				$table->unsignedInteger('quantity', false);
				$table->double('price_at_purchase', null, 2);
				$table->enum('status', ['PENDING_LPO', 'SENT_LPO', 'ACCEPTED_LPO', 'RECEIVED_LPO', 'REJECTED_LPO'])
					->nullable();
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
			Schema::dropIfExists('order_items');
		}
	}
