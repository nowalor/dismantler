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
        Schema::create('car_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_part_type_id')->constrained();
            $table->foreignId('dismantle_company_id')->constrained();



            $table->string('name');
            $table->longText('comments');
            $table->longText('notes');
            $table->integer('quantity')->unsigned();
            $table->string('car_first_registration_date');
            $table->integer('kilo_watt')->unsigned();
            $table->string('transmission_type');

            $table->string('item_number');
            $table->string('car_item_number');
            $table->string('item_code');
            $table->string('condition');
            $table->string('oem_number');
            $table->string('shelf_number');
            $table->float('price1');
            $table->float('price2');
            $table->float('price3');
            $table->string('car_vin_code');
            $table->string('engine_code');
            $table->string('engine_type');
            $table->string('kilo_range');
            $table->integer('year');
            $table->string('color');
            $table->string('alternative_numbers')->nullable();

            /* $table->string('dito_number_fk'); */

            /* $table->foreign('dito_number_fk')->references('dito_number')->on('dito_numbers')->onDelete('cascade'); */
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
        Schema::dropIfExists('car_parts');
    }
};
