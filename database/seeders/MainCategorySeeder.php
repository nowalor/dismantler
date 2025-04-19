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
            'Lighting',
            'Brake system',
            'Electronic parts',
            'Transmission',
            'Information / communication systems',
            'Interior equipment',
            'Instruments',
            'Air conditioning',
            'Mirrors',
            'Cooling',
            'Steering',
            'Engine',
        ];

        foreach ($categories as $category) {
            DB::table('main_categories')->updateOrInsert(
                ['name' => $category],
                ['translation_key' => Str::slug($category, '_')]
            );
        }
    }
}
