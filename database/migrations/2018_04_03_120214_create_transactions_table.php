<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
	        $table->unsignedInteger('client_id', false);
	        $table->foreign('client_id')->references('id')->on('clients');
	        $table->unsignedInteger('user_id', false)->nullable();
	        $table->foreign('user_id')->references('id')->on('users');
	        $table->double('amount', null, 2);
	        $table->text('description');
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
        Schema::dropIfExists('transactions');
    }
}
