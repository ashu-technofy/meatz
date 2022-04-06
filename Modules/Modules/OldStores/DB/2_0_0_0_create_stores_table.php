<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->boolean('featured')->nullable();
            $table->boolean('status')->nullable();
            $table->unsignedBigInteger('cuisine_id')->index()->nullable();
            $table->text('name');
            $table->text('contact_name');
            $table->string('email')->nullable();
            $table->string('mobile');
            $table->string('password')->nullable();
            $table->text('about')->nullable();
            $table->text('policy')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->string('mode')->nullable();
            $table->integer('day_orders')->nullable();
            $table->json('working_days');
            $table->string('working_from');
            $table->string('working_to');
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
        Schema::dropIfExists('stores');
    }
}
