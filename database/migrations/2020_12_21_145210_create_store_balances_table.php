<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_balances', function (Blueprint $table) {
            $table->string('product_id', 36);
            $table->foreign('product_id')->references('id')->on('products');
            $table->string('store_id', 36);
            $table->foreign('store_id')->references('id')->on('stores');
            $table->integer('value');

            $table->primary(['product_id', 'store_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_balances');
    }
}
