<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCharacteristicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_characteristics', function (Blueprint $table) {
            $table->string('characteristic_id', 36);
            $table->foreign('characteristic_id')->references('id')->on('characteristics');
            $table->string('product_id', 36);
            $table->foreign('product_id')->references('id')->on('products');
            $table->string('value');

            $table->primary(['product_id', 'characteristic_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_characteristics');
    }
}
