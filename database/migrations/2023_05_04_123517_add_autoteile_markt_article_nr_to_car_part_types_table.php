<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('car_part_types', function (Blueprint $table) {
            $table->smallInteger('autoteile_markt_article_nr')->unsigned()->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('car_part_types', function (Blueprint $table) {
            $table->dropColumn('autoteile_markt_article_nr');
        });
    }
};
