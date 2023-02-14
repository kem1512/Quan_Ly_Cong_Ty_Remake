<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->bigInteger('id_department_parent')->unsigned()->nullable();
            $table->foreign('id_department_parent')->references('id')->on('departments')->onDelete('set null');
            $table->bigInteger('id_leader')->unsigned()->nullable();
            $table->foreign('id_leader')->references('id')->on('users')->onDelete('set null');
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('departments');
    }
};
