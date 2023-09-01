<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('engine_alias_engine_type', function (Blueprint $table) {
            $table->foreignId('engine_alias_id')->constrained();
            $table->foreignId('engine_type_id')->constrained();

            $table->primary(['engine_alias_id', 'engine_type_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('engine_alias_engine_type');
    }
};
