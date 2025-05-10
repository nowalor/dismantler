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
        Schema::table('dito_numbers', function (Blueprint $table) {
            $table->string('seo_link')->nullable()->after('dito_number');
            $table->string('route_key')->nullable()->after('dito_number');
            $table->string('standardized_production_date')->nullable()->after('dito_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dito_numbers', function (Blueprint $table) {
            //
        });
    }
};
