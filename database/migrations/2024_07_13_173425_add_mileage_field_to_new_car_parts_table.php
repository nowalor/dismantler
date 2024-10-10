<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *d
     * @return void
     */
    public function up()
    {
        Schema::table('new_car_parts', function (Blueprint $table) {
            $table->string('mileage');
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
