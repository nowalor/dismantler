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
            $table->unsignedInteger('article_nr_at_carbreaker')->nullable()->after('new_car_part_id');

            // Add an index for efficient lookup
            $table->index('article_nr_at_carbreaker', 'new_car_parts_article_nr_index');
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
