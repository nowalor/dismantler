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
        Schema::table('dismantle_companies', function (Blueprint $table) {
            $table->string('country');
            $table->unsignedBigInteger('external_id')->nullable();
            $table->string('platform');
            $table->string('email')->nullable();
            $table->string('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dismantle_companies', function (Blueprint $table) {
            //
        });
    }
};
