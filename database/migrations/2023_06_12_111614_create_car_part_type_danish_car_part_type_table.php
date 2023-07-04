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
        Schema::create('car_part_type_danish_car_part_type', function (Blueprint $table) {
            $table->foreignId('car_part_type_id')
                ->constrained('car_part_types');

            $table->foreignId('danish_car_part_type_id');

            $table->primary(['car_part_type_id', 'danish_car_part_type_id']);

            $table->foreign('danish_car_part_type_id', 'fk_danish_car_part_type_id')
                ->references('id')->on('danish_car_part_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_part_type_danish_car_part_type');
    }
};
