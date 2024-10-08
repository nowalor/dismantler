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
        Schema::table('orders', function (Blueprint $table) {
           $table->dropForeign(['car_part_id']);
           $table->dropColumn('car_part_id');

           $table->foreignId('new_car_part_id')
               ->after('id')
               ->constrained('new_car_parts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['new_car_part_id']);
            $table->dropColumn('car_part_id');

            $table->foreignId('car_part_id')
                ->after('id')
                ->constrained('car_parts');
        });
    }
};
