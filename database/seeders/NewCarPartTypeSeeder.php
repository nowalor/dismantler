<?php

namespace Database\Seeders;

use App\Models\CarPartType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class NewCarPartTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear the database
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('car_part_type_danish_car_part_type')->truncate();
        DB::table('car_part_type_german_car_part_type')->truncate();
        DB::table('car_part_type_swedish_car_part_type')->truncate();
        DB::table('car_part_types')->truncate();
        DB::table('danish_car_part_types')->truncate();
        DB::table('german_car_part_types')->truncate();
        DB::table('swedish_car_part_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $file = File::get(base_path() . '/database/data/part-types/part-types.json');
        $data = json_decode($file, true);

        foreach ($data as $item) {
            $partType = [
                'name' => $item['name'],
                // Underscore version of name without special characters
                'translation_key' =>  Str::slug($item['name'], '_'),
                'slug' =>  Str::slug($item['name'], '-'),
            ];

            logger($item['id']);

            if(isset($item['json_key'])) {
                $partType['json_key'] = $item['json_key'];
            }

            $carPartType = CarPartType::create($partType);

            // Only create related types if they don't already exist
            foreach ($item['danish_car_part_types'] as $danishType) {
                $carPartType->danishCarPartTypes()->firstOrCreate($danishType);
            }

            foreach ($item['swedish_car_part_types'] as $swedishType) {
                $carPartType->swedishCarPartTypes()->firstOrCreate($swedishType);
            }

            foreach ($item['german_car_part_types'] as $germanType) {
                $carPartType->germanCarPartTypes()->firstOrCreate($germanType);
            }
        }
    }
}
