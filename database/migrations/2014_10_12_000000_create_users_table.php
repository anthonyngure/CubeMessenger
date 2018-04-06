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
				$table->string('avatar')->default('users/default.png');
				$table->string('email')->nullable()->unique();
				$table->string('phone')->nullable()->unique();
				$table->string('password')->nullable();
				$table->string('password_recovery_code')->nullable();
				$table->enum('account_type', ['CUBE_MESSENGER_USER', 'CUBE_MESSENGER_RIDER', 'CLIENT_ADMIN', 'PURCHASING_HEAD',
					'DEPARTMENT_HEAD', 'DEPARTMENT_USER', 'CLIENT_USER'])->default('CUBE_MESSENGER_USER');
				$table->double('latitude', 8, 5)->nullable();
				$table->double('longitude', 8, 5)->nullable();
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
