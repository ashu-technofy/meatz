<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_options', function (Blueprint $table) {
            $table->id();
            $table->integer('sort');
            $table->unsignedBigInteger('parent_id')->index()->nullable();
            $table->unsignedBigInteger('store_id')->index()->nullable();
            $table->string('name');
            $table->float('price')->nullable();
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
        Schema::dropIfExists('store_options');
    }
}
