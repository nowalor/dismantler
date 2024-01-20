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
        Schema::create('german_dismantler_k_type', function (Blueprint $table) {
            $table->foreignId('german_dismantler_id')->constrained()
                ->cascadeOnDelete();
            $table->foreignId('k_type_id')->constrained()
                ->cascadeOnDelete();

            $table->primary(['german_dismantler_id', 'k_type_id'], 'pk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('german_dismantler_k_type');
    }
};
