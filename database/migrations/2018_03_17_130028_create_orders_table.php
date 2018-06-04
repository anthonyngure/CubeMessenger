<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	
	class CreateOrdersTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('orders', function (Blueprint $table) {
				$table->increments('id');
				$table->unsignedInteger('user_id', false);
				$table->foreign('user_id')->references('id')->on('users');
				$table->enum('status', ['AT_DEPARTMENT_HEAD', 'AT_PURCHASING_HEAD', 'REJECTED',
					'PENDING_DELIVERY', 'DELIVERED'])->default('AT_DEPARTMENT_HEAD');
				$table->unsignedInteger('rejected_by_id', false)->nullable();
				$table->foreign('rejected_by_id')->references('id')->on('users');
				$table->timestamp('department_head_acted_at')->nullable();
				$table->timestamp('purchasing_head_acted_at')->nullable();
				$table->timestamp('delivered_at')->nullable();
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
			Schema::dropIfExists('orders');
		}
	}
