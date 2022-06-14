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
        Schema::create('engine_type_german_dismantler', function (Blueprint $table) {
            $table->foreignId('engine_type_id')->constrained();
            $table->foreignId('german_dismantler_id')->constrained();

            $table->primary(['engine_type_id', 'german_dismantler_id'], 'pk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('engine_type_german_dismantler');
    }
};
