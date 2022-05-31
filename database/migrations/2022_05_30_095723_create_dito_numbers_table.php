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
        Schema::create('dito_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('producer');
            $table->string('brand')->nullable();
            $table->string('production_date')->nullable();
            $table->integer('dito_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dito_numbers');
    }
};
