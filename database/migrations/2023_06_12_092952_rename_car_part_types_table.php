<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::rename('car_part_types', 'danish_car_part_types');

        Schema::table('danish_car_part_types', function (Blueprint $table) {
            $table->dropTimestamps();
            $table->dropColumn('german_name');
            $table->dropColumn('autoteile_markt_article_nr');
        });
    }

    public function down(): void
    {
        Schema::rename('danish_car_part_types', 'car_part_types');
    }
};
