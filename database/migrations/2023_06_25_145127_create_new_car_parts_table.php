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
            $table->string('article_nr')->nullable();
            $table->unsignedBigInteger('original_id')->nullable();
            $table->foreignId('car_part_type_id')->nullable()->constrained();
            $table->foreignId('internal_dismantle_company_id')->nullable()->constrained('dismantle_companies');
            $table->unsignedBigInteger('external_dismantle_company_id')->nullable();
            $table->foreignId('data_provider_id')->constrained();

            $table->string('name')->nullable();
            $table->float('price')->nullable();
            $table->integer('quantity')->default(1);
            $table->string('sbr_part_code')->nullable();
            $table->string('sbr_car_code')->nullable();
            $table->string('original_number')->nullable();
            $table->string('quality')->nullable();
            $table->timestamp('dismantled_at')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('new_car_parts');
    }
};
