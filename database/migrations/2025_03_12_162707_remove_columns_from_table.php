<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Define the slugs of the categories to be removed
        $slugsToRemove = [
            'axle-suspension',
            'towing-device-attachments',
            'suspension',
            'fuel-supply-system',
            'wheel-drive',
            'windshield-washer-system',
            'ignition-glow-system',
        ];

        DB::table('main_categories')->whereIn('slug', $slugsToRemove)->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('main_categories')->insert([
            ['id' => 3, 'name' => 'Axle suspension', 'slug' => 'axle-suspension'],
            ['id' => 4, 'name' => 'Towing device / attachments', 'slug' => 'towing-device-attachments'],
            ['id' => 8, 'name' => 'Suspension', 'slug' => 'suspension'],
            ['id' => 15, 'name' => 'Fuel supply system', 'slug' => 'fuel-supply-system'],
            ['id' => 19, 'name' => 'Wheel drive', 'slug' => 'wheel-drive'],
            ['id' => 20, 'name' => 'Windshield washer system', 'slug' => 'windshield-washer-system'],
            ['id' => 21, 'name' => 'Ignition / glow system', 'slug' => 'ignition-glow-system'],
        ]);
    }
};
