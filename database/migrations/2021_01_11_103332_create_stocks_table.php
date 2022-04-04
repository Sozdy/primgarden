<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->boolean("is_active");
            $table->string("name");
            $table->string("type");
            $table->integer("discount_percent_all")->nullable();
            $table->integer("min_order_all")->nullable();
            $table->integer("discount_percent_max_all")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
