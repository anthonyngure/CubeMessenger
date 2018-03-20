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
				
				$table->unsignedInteger('assigned_to', false)->nullable();
				$table->foreign('assigned_to')->references('id')->on('users');
				
				$table->enum('type', ['IT', 'REPAIR']);
				$table->enum('status', ['NEW', 'PENDING', 'COMPLETE'])->default('NEW');
				
				$table->mediumText('details');
				$table->string('note')->nullable();
				$table->double('cost', 8, 2)->default(0);
				$table->date('schedule_date')->nullable();
				$table->time('schedule_time')->nullable();
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
