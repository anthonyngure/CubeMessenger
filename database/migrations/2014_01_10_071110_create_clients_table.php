<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	
	class CreateClientsTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('clients', function (Blueprint $table) {
				$table->increments('id');
				$table->string('name');
				$table->string('logo')->default('images/client_default.png');
				$table->string('email')->unique();
				$table->string('phone')->unique();
				$table->enum('account_type', ['POST_PAID', 'PRE_PAID'])->default('PRE_PAID');
				$table->double('limit', 8, 2)->default(0);
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
			Schema::dropIfExists('clients');
		}
	}
