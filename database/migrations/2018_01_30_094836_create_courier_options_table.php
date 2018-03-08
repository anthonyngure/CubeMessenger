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
				$table->double('base_cost', 8, 2)->default(0);
				$table->string('icon')->default('icons/default.png');
				$table->string('description')->nullable();
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
