<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryCharacteristicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_characteristics', function (Blueprint $table) {

            $table->string('category_id', 36);
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('characteristic_id', 36);
            $table->foreign('characteristic_id')->references('id')->on('characteristics');

            $table->primary(['category_id', 'characteristic_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_characteristics');
    }
}
