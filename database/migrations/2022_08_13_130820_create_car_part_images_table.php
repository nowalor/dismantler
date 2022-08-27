<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.

     * @return void
     */
    public function up()
    {
        Schema::create('car_part_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_part_id')->constrained();
            $table->string('origin_url');
            $table->string('thumbnail_url');
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
        Schema::dropIfExists('car_part_images');
    }
};
