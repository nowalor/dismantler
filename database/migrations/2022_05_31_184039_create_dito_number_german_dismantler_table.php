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
        Schema::create('dito_number_german_dismantler', function (Blueprint $table) {
            $table->foreignId('dito_number_id')->constrained();
            $table->foreignId('german_dismantler_id')->constrained();

            $table->primary(['dito_number_id', 'german_dismantler_id'], 'pk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dito_number_german_dismantler');
    }
};
