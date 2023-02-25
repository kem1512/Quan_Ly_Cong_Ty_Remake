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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('image', 500);
            $table->string('specifications', 500);
            $table->enum('status', [
                'active',
                'inactive',
                'broken',
            ]);
            $table->integer('price');
            $table->date('out_of_date');
            $table->date('warranty_date');

            $table->bigInteger('equipment_type_id')->unsigned()->nullable();
            $table->foreign('equipment_type_id')->references('id')->on('equipment_types');

            $table->bigInteger('supplier_id')->unsigned()->nullable();
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
        Schema::dropIfExists('equiments');
    }
};