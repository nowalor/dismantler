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
        Schema::table('new_car_part_images', function (Blueprint $table) {
            $table->string('new_logo_german')->nullable();
            $table->string('new_logo_danish')->nullable();
            $table->string('new_logo_english')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('new_car_part_images', function (Blueprint $table) {
            //
        });
    }
};
