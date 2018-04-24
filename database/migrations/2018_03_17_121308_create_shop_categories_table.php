<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	
	class CreateShopCategoriesTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('shop_categories', function (Blueprint $table) {
				$table->increments('id');
				$table->string('name')->unique();
				$table->unsignedSmallInteger('order')->default(1);
				$table->string('slug')->nullable()->unique();
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
			Schema::dropIfExists('shop_categories');
		}
	}
