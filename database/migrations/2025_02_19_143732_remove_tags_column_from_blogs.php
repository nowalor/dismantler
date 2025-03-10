<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn('tags'); // Remove incorrect tags column
        });
    }

    public function down()
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->json('tags')->nullable(); // If rollback is needed
        });
    }
};
