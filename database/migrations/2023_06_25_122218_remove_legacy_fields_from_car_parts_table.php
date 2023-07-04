<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('car_parts', function (Blueprint $table) {
            $table->removeColumn('comments');
            $table->removeColumn('notes');
            $table->removeColumn('car_first_registration_date');
            $table->removeColumn('name_for_search');
        });
    }

    public function down(): void
    {
        Schema::table('car_parts', function (Blueprint $table) {
            //
        });
    }
};
