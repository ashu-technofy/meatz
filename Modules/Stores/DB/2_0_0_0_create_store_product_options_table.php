<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreProductOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_product_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->index()->nullable();
            $table->unsignedBigInteger('options_id')->index()->nullable();
            $table->integer('min');
            $table->integer('max');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_product_options');
    }
}
