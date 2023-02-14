<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storehouse_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('storehouse_id')->unsigned()->nullable();
            $table->foreign('storehouse_id')->references('id')->on('storehouses');
            $table->bigInteger('equiment_id')->unsigned()->nullable();
            $table->foreign('equiment_id')->references('id')->on('equiments');
            $table->integer('amount');
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
        Schema::dropIfExists('storehouse_details');
    }
};