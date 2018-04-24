<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	
	class CreateUsersTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('users', function (Blueprint $table) {
				$table->increments('id');
				$table->unsignedInteger('client_id', false)->nullable();
				$table->foreign('client_id')->references('id')->on('users');
				$table->unsignedInteger('department_id', false)->nullable();
				$table->foreign('department_id')->references('id')->on('departments');
				$table->string('name');
				$table->string('email')->nullable()->unique();
				$table->string('phone')->nullable()->unique();
				$table->string('password')->nullable();
				$table->string('password_recovery_code')->nullable();
				$table->rememberToken();
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
			Schema::dropIfExists('users');
		}
	}
