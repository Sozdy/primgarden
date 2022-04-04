<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakePricesFloatOnStockProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stock_products', function (Blueprint $table) {
            $table->float('discount_percent')->change();
            $table->float('discount_percent_max')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_products', function (Blueprint $table) {
            $table->integer('discount_percent')->change();
            $table->integer('discount_percent_max')->change();
        });
    }
}
