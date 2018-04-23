<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_products', function (Blueprint $table) {
	        $table->increments('id');
	        $table->unsignedInteger('shop_category_id', false);
	        $table->foreign('shop_category_id')->references('id')->on('shop_categories');
	        $table->string('name');
	        $table->string('image')->default('images/shop_product_default.jpg');
	        $table->string('slug')->nullable()->unique();
	        $table->double('price', null, 2);
	        $table->double('old_price', null, 2)->default(0);
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
        Schema::dropIfExists('shop_products');
    }
}
