<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	
	class CreateAppointmentsTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('appointments', function (Blueprint $table) {
				$table->increments('id');
				$table->unsignedInteger('user_id', false);
				$table->foreign('user_id')->references('id')->on('users');
				$table->timestamp('starting_at')->nullable();
				$table->timestamp('ending_at')->nullable();
				$table->boolean('all_day')->default(false);
				$table->string('venue');
				$table->string('title');
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
			Schema::dropIfExists('appointments');
		}
	}
