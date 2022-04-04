<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->string('product_id', 36);
            $table->foreign('product_id')->references('id')->on('products');
            $table->string('price_type_id', 36);
            $table->foreign('price_type_id')->references('price_type_id')->on('stores');
            $table->integer('value');

            $table->primary(['product_id', 'price_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
}
