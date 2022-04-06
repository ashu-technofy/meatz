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
            $table->id();
            $table->boolean('seen')->nullable();
            $table->string('status', 20)->default('pending');
            $table->enum('type', ['now', 'delivery'])->default('now');
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->unsignedBigInteger('address_id')->index()->nullable();
            $table->unsignedBigInteger('copon_id')->index()->nullable();
            $table->float('total');
            $table->float('subtotal');
            $table->float('discount');
            $table->float('delivery');
            $table->date('delivery_date')->nullable();
            $table->string('delivery_time')->nullable();
            $table->string('payment_method');
            $table->string('notes')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
