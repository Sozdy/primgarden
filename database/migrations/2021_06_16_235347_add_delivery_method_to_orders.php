<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveryMethodToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            //$table->dropColumn("delivery_method_id");
            $table->string('delivery_method_id', 36)->nullable();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('delivery_method_id')->references('id')->on('delivery_methods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(["delivery_method_id"]);
            $table->dropColumn("delivery_method_id");
        });
    }
}
