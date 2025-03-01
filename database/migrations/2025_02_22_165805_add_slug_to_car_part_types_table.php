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
        Schema::table('car_part_types', function (Blueprint $table) {
            // Adding a slug column that is unique and nullable (in case you want to update existing rows later)
            $table->string('slug')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('car_part_types', function (Blueprint $table) {
            // Dropping the slug column in case of a rollback
            $table->dropColumn('slug');
        });
    }
};
