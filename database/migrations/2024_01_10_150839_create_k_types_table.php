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
        Schema::create('k_types', function (Blueprint $table) {
            $table->id();
            $table->string('k_type');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('type')->nullable();
            $table->string('platform')->nullable();
            $table->string('production_period')->nullable();
            $table->string('engine_information')->nullable();
            $table->string('kba_string')->nullable();
            $table->string('number_of_years_in_construction')->nullable();
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
        Schema::dropIfExists('k_types');
    }
};
