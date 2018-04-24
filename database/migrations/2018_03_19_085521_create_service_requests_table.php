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
				
				$table->unsignedInteger('user_id', false);
				$table->foreign('user_id')->references('id')->on('users');
				
				$table->unsignedInteger('assigned_to', false)->nullable();
				$table->foreign('assigned_to')->references('id')->on('users');
				
				$table->enum('type', ['IT', 'REPAIR']);
				$table->enum('status', ['AT_DEPARTMENT_HEAD', 'AT_PURCHASING_HEAD', 'PENDING_QUOTE',
					'PENDING_QUOTE_CONFIRMATION', 'QUOTE_REJECTED', 'PENDING_ATTENDANCE', 'ATTENDED', 'REJECTED'])
					->default('AT_DEPARTMENT_HEAD');
				$table->unsignedInteger('rejected_by_id', false)->nullable();
				$table->foreign('rejected_by_id')->references('id')->on('users');
				$table->longText('details');
				$table->string('note')->nullable();
				$table->date('schedule_date')->nullable();
				$table->time('schedule_time')->nullable();
				
				$table->timestamp('department_head_acted_at')->nullable();
				$table->timestamp('purchasing_head_acted_at')->nullable();
				$table->timestamp('attended_at')->nullable();
				$table->timestamp('completed_at')->nullable();
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
			Schema::dropIfExists('service_requests');
		}
	}
