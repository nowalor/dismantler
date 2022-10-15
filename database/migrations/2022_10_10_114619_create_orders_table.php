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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_part_id')->constrained();
            $table->foreignId('dismantle_company_id')->constrained();
            $table->foreignId('payment_platform_id')->constrained();
            $table->foreignId('iso_id')->constrained('countries');
            $table->string('buyer_name');
            $table->string('buyer_email')->nullable();
            $table->unsignedSmallInteger('quantity');
            $table->unsignedBigInteger('part_price')->unsigned();
            $table->boolean('is_part_delivered')->default(false);
            $table->string('city');
            $table->string('zip_code');
            $table->string('address');
            $table->string('secondary_address');
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
};
