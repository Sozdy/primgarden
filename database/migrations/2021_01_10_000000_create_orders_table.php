<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string("first_name")->nullable();
            $table->string("last_name")->nullable();
            $table->string("user_id", 36)->nullable();
            $table->string("contact_person")->nullable();
            $table->string("phone")->nullable();
            $table->string("email")->nullable();
            $table->string("store_id", 36)->nullable();
            $table->string("delivery_type", 30);
            $table->string("delivery_address")->nullable();
            $table->string("delivery_comment")->nullable();
            $table->string("comment")->nullable();
            $table->boolean("is_synchronized")->default(false);
            $table->string("status")->default("just_created");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
