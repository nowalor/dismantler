<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('new_car_part_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('new_car_part_id')->constrained();
            $table->string('original_url')->nullable();
            $table->string('image_name')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('new_car_part_images');
    }
};
