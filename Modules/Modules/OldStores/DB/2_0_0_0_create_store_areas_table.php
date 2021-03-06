<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_areas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('area_id')->index()->nullable();
            $table->unsignedBigInteger('store_id')->index()->nullable();
            $table->float('delivery');
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
        Schema::dropIfExists('store_areas');
    }
}
