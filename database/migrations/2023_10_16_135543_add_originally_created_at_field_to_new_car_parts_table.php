<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('new_car_parts', function (Blueprint $table) {
            $table->timestamp('originally_created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('new_car_parts', function (Blueprint $table) {
            //
        });
    }
};
