<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('car_part_images', function (Blueprint $table) {
            $table->string('thumbnail_url')->nullable()->change();
            $table->string('image_with_our_logo_url')->nullable();
        });
    }
};
