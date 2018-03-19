<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	
	class CreateServiceRequestsTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('service_requests', function (Blueprint $table) {
				$table->increments('id');
				
				$table->unsignedInteger('client_id', false);
				$table->foreign('client_id')->references('id')->on('clients');
				
				$table->unsignedInteger('service_request_option_id', false);
				$table->foreign('service_request_option_id')->references('id')->on('service_request_options');
				
				$table->unsignedInteger('assigned_to', false)->nullable();
				$table->foreign('assigned_to')->references('id')->on('users');
				
				$table->enum('status', ['NEW', 'PENDING', 'COMPLETE']);
				$table->string('note');
				$table->double('cost', 8, 2)->default(0);
				$table->date('scheduled_date');
				$table->time('scheduled_time');
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
			Schema::dropIfExists('service_requests');
		}
	}
