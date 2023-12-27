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
        Schema::create('german_dismantler_new_car_part', function (Blueprint $table) {
          $table->foreignId('german_dismantler_id')->constrained();
          $table->foreignId('new_car_part_id')->constrained();

          $table->primary(['german_dismantler_id', 'new_car_part_id'], 'pk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('german_dismantler_new_car_part');
    }
};
