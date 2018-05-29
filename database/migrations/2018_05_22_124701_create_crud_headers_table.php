<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Database\Schema\Blueprint;
	
	class CreateCrudHeadersTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return void
		 */
		public function up()
		{
			Schema::create('crud_headers', function (Blueprint $table) {
				$table->increments('id');
				$table->string('model');
				$table->string('text');
				$table->enum('align', ['left', 'center', 'right'])->default('left');
				$table->string('value');
				$table->enum('type', ['text','textarea', 'number', 'email', 'boolean', 'select', 'select_remote', 'date', 'time', 'timestamp'])->default('text');
				$table->text('options')->nullable()->comment('Comma separated or url to options for select_remote');
				$table->string('mask')->nullable();
				$table->unsignedInteger('priority')->default(0);
				$table->string('edit_hint')->nullable();
				$table->string('create_hint')->nullable();
				$table->boolean('edit_required')->default(true);
				$table->boolean('create_required')->default(true);
				$table->boolean('viewable')->default(true);
				$table->boolean('editable')->default(true);
				$table->boolean('creatable')->default(true);
				$table->boolean('browsable')->default(true);
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
			Schema::dropIfExists('crud_headers');
		}
	}
