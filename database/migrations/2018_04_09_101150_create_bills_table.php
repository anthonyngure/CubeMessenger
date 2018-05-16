<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	
	class CreateBillsTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('bills', function (Blueprint $table) {
				$table->increments('id');
				$table->unsignedInteger('client_id', false);
				$table->foreign('client_id')->references('id')->on('clients');
				$table->unsignedInteger('billable_id', false);
				$table->string('billable_type', false);
				$table->double('amount', null, 2);
				$table->enum('status', ['BLOCKED', 'SETTLED'])->default('BLOCKED');
				$table->text('description')->nullable();
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
			Schema::dropIfExists('bills');
		}
	}
