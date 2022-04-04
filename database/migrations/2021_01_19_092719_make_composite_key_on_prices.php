<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeCompositeKeyOnPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->dropColumn("id");
            //$table->dropPrimary();
        });
        Schema::table('prices', function (Blueprint $table) {
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
        Schema::table('prices', function (Blueprint $table) {
            $table->dropPrimary();
        });
        Schema::table('prices', function (Blueprint $table) {
            $table->bigIncrements("id");
        });
    }
}
