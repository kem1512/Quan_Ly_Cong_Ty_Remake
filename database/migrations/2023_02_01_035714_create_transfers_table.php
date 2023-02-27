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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_transfer_id')->unsigned()->nullable();
            $table->foreign('user_transfer_id')->references('id')->on('users');
            $table->bigInteger('user_receive_id')->unsigned()->nullable();
            $table->foreign('user_receive_id')->references('id')->on('users');
            $table->bigInteger('performer_id')->unsigned()->nullable();
            $table->foreign('performer_id')->references('id')->on('users');
            $table->enum('transfer_type', ['hand_over', 'recall']);
            $table->string('transfer_detail', 500);
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
        Schema::dropIfExists('transfers');
    }
};