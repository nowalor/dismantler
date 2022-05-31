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
        Schema::create('german_dismantlers', function (Blueprint $table) {
            $table->id();
            $table->string('hsn');
            $table->string('tsn');
            $table->string('manufacturer_plaintext');
            $table->string('make')->nullable();
            $table->string('commercial_name')->nullable();
            $table->string('date_of_allotment_of_type_code_number')->nullable();
            $table->string('vehicle_category')->nullable();
            $table->string('code_for_bodywork')->nullable();
            $table->string('code_for_the_fuel_or_power_source')->nullable();
            $table->integer('max_net_power_in_kw')->nullable();
            $table->integer('engine_capacity_in_cm')->nullable();
            $table->integer('max_number_of_axles')->nullable();
            $table->integer('max_number_of_powered_axles')->nullable();
            $table->integer('max_number_of_seats')->nullable();
            $table->integer('technically_permissible_maximum_mass_in_kg')->nullable();
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
        Schema::dropIfExists('german_dismantlers');
    }
};
