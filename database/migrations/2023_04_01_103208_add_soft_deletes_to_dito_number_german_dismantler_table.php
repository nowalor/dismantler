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
        Schema::table('dito_number_german_dismantler', function (Blueprint $table) {
            $table->softDeletes();
//            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dito_number_german_dismantler', function (Blueprint $table) {
            $table->dropSoftDeletes();
//            $table->dropTimestamps();
        });
    }
};
