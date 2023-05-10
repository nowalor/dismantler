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
        Schema::create('dito_number_sbr_code', function (Blueprint $table) {
            $table->foreignId('dito_number_id')->constrained();
            $table->foreignId('sbr_code_id')->constrained();

            $table->primary(['dito_number_id', 'sbr_code_id'], 'dito_number_sbr_code_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dito_number_sbr_code');
    }
};
