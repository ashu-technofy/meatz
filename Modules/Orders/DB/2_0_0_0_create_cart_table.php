<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id')->index()->nullable();
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->unsignedBigInteger('guest_id')->index()->nullable();
            $table->unsignedBigInteger('product_id')->index();
            $table->text('options')->nullable();
            $table->float('total')->nullable();
            $table->integer('count')->default(1);
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('cart');
    }
}
