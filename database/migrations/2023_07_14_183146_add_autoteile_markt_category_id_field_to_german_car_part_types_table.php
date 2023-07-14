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
        Schema::table('german_car_part_types', function (Blueprint $table) {
            $table->unsignedBigInteger('autoteile_markt_category_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('german_car_part_types', function (Blueprint $table) {
            $table->dropColumn('autoteile_markt_category_id');
        });
    }
};
