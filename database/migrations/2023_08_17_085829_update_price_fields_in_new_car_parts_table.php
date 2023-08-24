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
            $table->dropColumn('price');

            $table->decimal('price_sek', 20, 2, true)->nullable();
            $table->decimal('price_dkk', 20, 2, true)->nullable();
            $table->decimal('price_eur', 20, 2, true)->nullable();
            $table->decimal('price_nok', 20, 2, true)->nullable();
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
            //
        });
    }
};
