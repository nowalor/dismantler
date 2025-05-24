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
        Schema::table('new_car_parts', function (Blueprint $table) {
            $table->index('sbr_part_code', 'idx_sbr_part_code');
            $table->index('sbr_car_code', 'idx_sbr_car_code');
            $table->index('original_number', 'idx_original_number');
            $table->index('engine_code', 'idx_engine_code');
            $table->index('engine_type', 'idx_engine_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('new_car_parts', function (Blueprint $table) {
            $table->dropIndex('idx_sbr_part_code');
            $table->dropIndex('idx_sbr_car_code');
            $table->dropIndex('idx_original_number');
            $table->dropIndex('idx_engine_code');
            $table->dropIndex('idx_engine_type');
        });
    }
};
