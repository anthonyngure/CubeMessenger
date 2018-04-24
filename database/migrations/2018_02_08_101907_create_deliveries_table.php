<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	
	class CreateDeliveriesTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('deliveries', function (Blueprint $table) {
				$table->increments('id');
				$table->unsignedInteger('user_id', false);
				$table->foreign('user_id')->references('id')->on('users');
				$table->boolean('urgent');
				$table->string('origin_name');
				$table->string('origin_vicinity');
				$table->string('origin_formatted_address');
				$table->double('origin_latitude', 8, 5);
				$table->double('origin_longitude', 8, 5);
				$table->date('schedule_date');
				$table->time('schedule_time');
				$table->double('estimated_cost', 8, 2);
				$table->double('estimated_max_distance', 8, 2);
				$table->double('estimated_max_duration', 8, 2);
				$table->unsignedInteger('rider_id', false)->nullable();
				$table->foreign('rider_id')->references('id')->on('users');
				$table->timestamp('pickup_time')->nullable();
				$table->double('pickup_latitude', 8, 5)->nullable();
				$table->double('pickup_longitude', 8, 5)->nullable();
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
			Schema::dropIfExists('deliveries');
		}
	}
