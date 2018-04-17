<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	
	class CreateServiceRequestQuotesTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('service_request_quotes', function (Blueprint $table) {
				$table->increments('id');
				$table->unsignedInteger('service_request_id', false);
				$table->foreign('service_request_id')->references('id')->on('service_requests');
				$table->string('note')->nullable();
				$table->double('diagnosis_cost', 8, 2);
				$table->double('labour_cost', 8, 2);
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
			Schema::dropIfExists('service_request_quotes');
		}
	}
