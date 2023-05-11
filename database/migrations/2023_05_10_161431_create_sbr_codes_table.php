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
        Schema::create('sbr_codes', function (Blueprint $table) {
            $table->id();
            $table->string('sbr_code')->unique();
            $table->string('name');
            $table->string('new_code')->nullable();
            $table->string('update_code')->nullable();
            $table->string('removed_code')->nullable();
            $table->string('remark')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sbr_codes');
    }
};
