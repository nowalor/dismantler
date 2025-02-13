<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MainCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Exhaust system',
            'Axle drive',
            'Axle suspension',
            'Towing device / attachments',
            'Lighting',
            'Brake system',
            'Electronic parts',
            'Suspension',
            'Transmission',
            'Information / communication systems',
            'Interior equipment',
            'Instruments',
            'Air conditioning',
            'Mirrors',
            'Fuel supply system',
            'Cooling',
            'Steering',
            'Engine',
            'Wheel drive',
            'Windshield washer system',
            'Ignition / glow system',
        ];

        foreach ($categories as $category) {
            DB::table('main_categories')->updateOrInsert(
                ['name' => $category],
                ['translation_key' => Str::slug($category, '_')]
            );
        }
    }
}
