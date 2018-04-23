<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	
	class CreateCourierOptionsTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('courier_options', function (Blueprint $table) {
				$table->increments('id');
				$table->string('name')->unique();
				$table->string('plural_name')->unique();
				$table->string('icon');
				$table->boolean('active')->default(true);
				$table->mediumText('description')->nullable();
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
			Schema::dropIfExists('courier_options');
		}
	}
