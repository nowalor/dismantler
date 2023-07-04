<?php

namespace Database\Seeders;

use App\Models\CarPartType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarPartTypeSeeder extends Seeder
{
    public function run(): void
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

        $carPartTypes = [
            [
                'id' => 1,
                'name' => 'Engine',
            ],
            [
                'id' => 2,
                'name' => 'Distribution gear box',
            ],
            [
                'id' => 3,
                'name' => 'Gearbox Automatic',
            ],
            [
                'id' => 4,
                'name' => 'Gearbox 6 gear',
            ],
            [
                'id' => 5,
                'name' => 'Particle Filter',
            ],
            [
                'id' => 6,
                'name' => 'CATALYST',
            ],
            [
                'id' => 7,
                'name' => 'Differential',
            ],
        ];

        CarPartType::insert($carPartTypes);

        $danishPartTypes = [
            ["id" => 1, "name" => "MOTOR", "code" => "0010"],
            ["id" => 2, "name" => "FORDELERGEARKASSE", "code" => "2020"],
            ["id" => 3, "name" => "GEARKASSE  AUTOMATIC", "code" => "2022"],
            ["id" => 4, "name" => "GEARKASSE 6 GEAR", "code" => "2026"],
            ["id" => 5, "name" => "PARTIKELFILTER", "code" => "1284"],
            ["id" => 6, "name" => "KATALYSATOR", "code" => "1285"],
            ["id" => 7, "name" => "BAGTØJSKLUMP", "code" => "2601"],
        ];

        DB::table('danish_car_part_types')->insert($danishPartTypes);

        $germanPartTypes = [
            ["id" => 1, "name" => "Motor", "code" => null],
            ["id" => 2, "name" => "Automatikgetriebe", "code" => null],
            ["id" => 3, "name" => "Automatikgetriebe", "code" => null],
            ["id" => 4, "name" => "Schaltgetriebe 6-Gang", "code" => null],
            ["id" => 5, "name" => "Partikelfilter", "code" => null],
            ["id" => 6, "name" => "Katalysator", "code" => null],
            ["id" => 7, "name" => "Differential", "code" => null],
        ];

        DB::table('german_car_part_types')->insert($germanPartTypes);

        $carPartTypes = CarPartType::all();

        foreach ($carPartTypes as $carPartType) {
            $carPartType->danishCarPartTypes()->attach($carPartType->id);
            $carPartType->germanCarPartTypes()->attach($carPartType->id);
        }

        $swedishPartTypes = [
            ["id" => 1, "name" => "MOTOR BENSIN", "code" => "7201"], // 1 in danish
            ["id" => 2, "name" => "MOTOR DIESEL", "code" => "7280"], // 1 in danish
            ["id" => 3 , "name" => "VÄXEL FÖRDELNINGSLÅDA", "code" => "7704"], // 2 in danish
            ["id" => 4, "name" => "VÄXELLÅDA TRONIC", "code" => "7700"], // 3 in danish
            ["id" => 5, "name" => "VÄXELLÅDA AUTOMAT", "code" => "7705"], // 3 in danish
            ["id" => 6, "name" => "VÄXELLÅDA MAN. 6 VXL", "code" => "7706"], // 4 in danish
            ["id" => 7, "name" => "AVGAS PARTIKELFILTER", "code" => "7868"], // 5
            ["id" => 8, "name" => "KATALYSATOR", "code" => "7860"], // 6
            ["id" => 9, "name" => "FRAMVAGN DIFFRENTIAL", "code" => "7070"], // 7
            ["id" => 10, "name" => "BAKVÄXEL/DIFF.", "code" => "7145"], // 7
        ];

        DB::table('swedish_car_part_types')->insert($swedishPartTypes);

        CarPartType::find(1)->swedishCarPartTypes()->syncWithoutDetaching([1, 2]);
        CarPartType::find(2)->swedishCarPartTypes()->syncWithoutDetaching([3]);
        CarPartType::find(3)->swedishCarPartTypes()->syncWithoutDetaching([4, 5]);
        CarPartType::find(4)->swedishCarPartTypes()->syncWithoutDetaching([6]);
        CarPartType::find(5)->swedishCarPartTypes()->syncWithoutDetaching([7]);
        CarPartType::find(6)->swedishCarPartTypes()->syncWithoutDetaching([8]);
        CarPartType::find(7)->swedishCarPartTypes()->syncWithoutDetaching([9, 10]);

    }
}
