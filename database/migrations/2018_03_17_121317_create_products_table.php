<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
	        $table->increments('id');
	        $table->unsignedInteger('category_id', false);
	        $table->foreign('category_id')->references('id')->on('categories');
	        $table->unsignedInteger('supplier_id', false);
	        $table->foreign('supplier_id')->references('id')->on('users')->nullable();
	        $table->string('name');
	        $table->string('image')->default('images/product_default.jpg');
	        $table->string('slug')->nullable()->unique();
	        $table->double('price', null, 2);
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
        Schema::dropIfExists('products');
    }
}
