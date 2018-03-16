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
				$table->unsignedInteger('client_id', false);
				$table->foreign('client_id')->references('id')->on('clients');
				$table->date('start_date');
				$table->time('start_time')->nullable();
				$table->date('end_date');
				$table->time('end_time')->nullable();
				$table->unsignedInteger('with_id', false);
				$table->foreign('with_id')->references('id')->on('users');
				$table->string('venue');
				$table->string('title');
				$table->boolean('all_day')->default(false);
				$table->string('note')->nullable();
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
