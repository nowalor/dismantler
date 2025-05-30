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
        Schema::create('dismantle_companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('full_name');
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
        Schema::table('car_parts', function (Blueprint $table) {
            $table->dropConstrainedForeignId('dismantle_company_id');
        });
        Schema::dropIfExists('dismantle_companies');
    }
};
