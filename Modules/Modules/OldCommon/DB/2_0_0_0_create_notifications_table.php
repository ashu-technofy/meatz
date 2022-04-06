<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('model')->default('product');
            $table->string('type', 20)->nullable();
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->unsignedBigInteger('guest_id')->index()->nullable();
            $table->unsignedBigInteger('product_id')->index()->nullable();
            $table->unsignedBigInteger('order_id')->index()->nullable();
            $table->text('text');
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
        Schema::dropIfExists('notifications');
    }
}
