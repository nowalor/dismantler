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
            'Body parts',
            'Fuel system',
            'Audio/Communication system',
            'Brake system',
            'Gearbox/Transmission',
            'Chassis/Steering',
            'Cooling/Heating/Aircon',
            'Switches/Relays/Sensor',
            'Looks/Locking system',
            'Wipers',
            'Interior',
            'Electronic parts',
            'Lights/Mirrors',
            'Engine/Engine parts',
            'Exhaust system',
            'Instruments',
        ];

        //DB::table('main_category_car_part_type')->delete();
        //DB::table('main_categories')->delete();

        foreach ($categories as $category) {
            DB::table('main_categories')->insert([
                'name' => $category,
                'translation_key' => Str::slug($category, '_'),
                'slug' => Str::slug($category),
            ]);
        }
    }
}
