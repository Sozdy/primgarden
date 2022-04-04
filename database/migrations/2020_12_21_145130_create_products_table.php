<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('id', 36)->primary();

            $table->string('category_id', 36);
            $table->foreign('category_id')->references('id')->on('categories');

            $table->string('name');
            $table->string('unit_name');
            $table->string('vendor_code');

            $table->text('description');

            $table->boolean('is_active');
            $table->boolean('is_bestseller');
            $table->boolean('is_product_of_the_day');

            $table->integer('minimal_order_count');
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
