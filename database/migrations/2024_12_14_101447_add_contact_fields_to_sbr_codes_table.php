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
        Schema::table('sbr_codes', function (Blueprint $table) {
            $table->string('producer_address')->nullable();
            $table->string('producer_email')->nullable();
            $table->string('producer_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sbr_codes', function (Blueprint $table) {
            $table->dropColumn('producer_address');
            $table->dropColumn('producer_email');
            $table->dropColumn('producer_phone');
        });
    }
};
