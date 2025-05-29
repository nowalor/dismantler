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
            // Sorting indexes
            $table->index('model_year', 'idx_model_year');
            $table->index('mileage_km', 'idx_mileage_km');
            $table->index('price_sek', 'idx_price_sek');

            // Composite index for country filter + price sort
            $table->index(['country', 'price_sek'], 'idx_country_price');
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
            $table->dropIndex('idx_model_year');
            $table->dropIndex('idx_mileage_km');
            $table->dropIndex('idx_price_sek');
            $table->dropIndex('idx_country_price');
        });
    }
};
