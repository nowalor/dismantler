<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('new_car_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_provider_id')->constrained();
            $table->foreignId('car_part_type_id')->nullable()->constrained();
            $table->foreignId('dito_number_id')->nullable()->constrained('dito_numbers');
            $table->foreignId('sbr_code_id')->nullable()->constrained('sbr_codes');
            $table->foreignId('internal_dismantle_company_id')->nullable()->constrained('dismantle_companies');

            $table->string('article_nr')->unique()->nullable();

            $table->unsignedBigInteger('external_dismantle_company_id')->nullable();
            $table->unsignedBigInteger('original_id')->nullable();

            $table->string('name')->nullable();
            $table->float('price')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('sbr_part_code')->nullable();
            $table->string('sbr_car_code')->nullable();
            $table->string('original_number')->nullable();
            $table->string('quality')->nullable();
            $table->string('engine_code')->nullable();
            $table->string('engine_type')->nullable();
            $table->timestamp('dismantled_at')->nullable();

            $table->string('dismantle_company_name')->nullable();
            $table->string('article_nr_at_dismantler')->nullable();
            $table->string('sbr_car_name')->nullable();
            $table->string('body_name')->nullable();
            $table->string('fuel')->nullable();
            $table->string('gearbox')->nullable();
            $table->string('warranty')->nullable();
            $table->string('mileage_km');
            $table->string('model_year');
            $table->string('vin')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('new_car_parts');
    }
};
