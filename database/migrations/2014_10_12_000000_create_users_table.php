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
				$table->string('name');
				$table->string('avatar')->default('users/default.png');
				$table->string('email')->nullable()->unique();
				$table->string('email_verification_code')->nullable();
				$table->boolean('email_verified')->default(false);
				$table->string('phone')->nullable()->unique();
				$table->string('phone_verification_code')->nullable();
				$table->boolean('phone_verified')->default(false);
				$table->string('password')->nullable();
				$table->string('password_recovery_code')->nullable();
				$table->enum('account_type', ['CUBE_MESSENGER_USER', 'CUBE_MESSENGER_RIDER', 'CLIENT_ADMIN',
					'CLIENT_PURCHASING_HEAD', 'CLIENT_DEPARTMENT_HEAD', 'CLIENT_DEPARTMENT_USER', 'CLIENT_USER'])
					->default('CUBE_MESSENGER_USER');
				$table->double('latitude', 8, 5)->nullable();
				$table->double('longitude', 8, 5)->nullable();
				$table->rememberToken();
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
			Schema::dropIfExists('users');
		}
	}
