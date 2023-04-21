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
        Schema::table('german_dismantlers', function (Blueprint $table) {
            $table->string('full_name')->nullable();
            $table->string('construction_year')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('german_dismantlers', function (Blueprint $table) {
            $table->dropColumn('full_name');
            $table->dropColumn('construction_year');
        });
    }
};
