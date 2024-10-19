<?php

namespace Database\Seeders;

use App\Models\CarPartType;
use App\Models\DanishCarPartType;
use App\Models\GermanCarPartType;
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


//        STYRENHET ABS 7475 ABS Bremsaggregat
    //ABS HYDRAULAGGREGAT 7645 ABS Bremsaggregat
    //INSTRUMENT KOMB. 3220 Instrumente Tachometer
    //STYRENHET VÄXELLÅDA 7468 Elektrik Steuergerät Automatikgetr
    //STYRSERVOPUMP ELEKTRISK 7082 Lenkung Servolenkung Lenkgetrie
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

            // TODO ASK MARCUS TO BE SURE
            // DITO 3950 = EGLUIT 3969

            [
                'id' => 8,
                'name' => 'Break Unit ABS',
            ],
            // 3952 DITO
            // 3971 EGLUIT
            [
                'id' => 9,
                'name' => 'ABS Hydraulic unit',
            ],
            // 6012 DITO
            // 4233 EGLUIT
             [
                'id' => 10,
                'name' => 'Instrument comb',
            ],
            //  2157 Ignoring this one for now
            // DITO 2156 = EGLUIT 3757
           [
                'id' => 11,
                'name' => 'Steering unit gearbox',
            ],
            // DITO 3137
            // EGLUIT 3851
            [
                'id' => 12,
                'name' => 'Power steering pump electric',
            ],
            [
                'id' => 13,
                'name' => 'Engine control unit (ECU)',
            ],
            [
                'id' => 14,
                'name' => 'Engine control unit Diesel (ECU)',
            ],
            [
               'id' => 15,
                'name' => 'Control Display',
            ],
            [
                'id' => 16,
                'name' => 'Turbo charger',
            ],
            [
                'id' => 17,
                'name' => 'Power Distribution controller',
            ],
            [
                'id' => 18,
                'name' => 'Display',
            ],
            [
                'id' => 19,
                'name' => 'Alternator',
            ],
            [
                'id' => 20,
                'name' => 'Automatic gearbox',
            ],
            [
                'id' => 21,
                'name' => 'Converter / inverter - electric',
            ],
        ];

        CarPartType::insert($carPartTypes);

        $danishPartTypes = [
            ["id" => 1, "name" => "MOTOR", "code" => "0010", 'egluit_id' => '3574'],
            ["id" => 2, "name" => "FORDELERGEARKASSE", "code" => "2020", 'egluit_id' => '3744'],
            ["id" => 3, "name" => "GEARKASSE  AUTOMATIC", "code" => "2022", 'egluit_id' => '3746'],
            ["id" => 4, "name" => "GEARKASSE 6 GEAR", "code" => "2026", 'egluit_id' => '3749'],
            ["id" => 5, "name" => "PARTIKELFILTER", "code" => "1284", 'egluit_id' => '3616'],
            ["id" => 6, "name" => "KATALYSATOR", "code" => "1285", 'egluit_id' => '3617'],
            ["id" => 7, "name" => "BAGTØJSKLUMP", "code" => "2601", 'egluit_id' => '3812'],
            // TODO get dito numbers for the new parts
            ["id" => 8, "name" => 'ABS BREMSESÆT', "code" => "3950", "egluit_id" => "3969"],
            ["id" => 9, "name" => 'ABS PUMPE', "code" => "3952", "egluit_id" => "3971"],
            ["id" => 10, "name" => 'INSTRUMENT MED OMDR', "code" => "6012", "egluit_id" => "4233"],
            ["id" => 11, "name" => 'AUTOMATGEAR ELBOKS', "code" => "2156", "egluit_id" => "3757"],
            ["id" => 12, "name" => 'SERVOELBOKS', "code" => "3137", "egluit_id" => "3851"],

        ];

        DB::table('danish_car_part_types')->insert($danishPartTypes);

        $germanPartTypes = [
            [
                "id" => 1,
                "name" => "Motor",
                "code" => null,
                "autoteile_markt_category_id" => 193,
            ],
            [
                "id" => 2,
                "name" => "Verteilergetriebe",
                "code" => null,
                "autoteile_markt_category_id" => 940,
            ],
            [
                "id" => 3,
                "name" => "Automatikgetriebe",
                "code" => null,
                "autoteile_markt_category_id" => 851,
            ],
            [
                "id" => 4,
                "name" => "Schaltgetriebe 6-Gang",
                "code" => null,
                "autoteile_markt_category_id" => 852,

            ],
            [
                "id" => 5,
                "name" => "Partikelfilter",
                "code" => null,
                "autoteile_markt_category_id" => 840,
            ],
            [
                "id" => 6,
                "name" => "Katalysator",
                "code" => null,
                "autoteile_markt_category_id" => 838,
            ],
            [
                "id" => 7,
                "name" => "Differential",
                "code" => null,
                "autoteile_markt_category_id" => 939,
            ],

            [
                "id" => 8,
                "name" => "ABS Bremsaggregat",
                "code" => null,
                "autoteile_markt_category_id" => 38,
            ],

            [
                "id" => 9,
                "name" => "Instrumente Tachometer",
                "code" => null,
                "autoteile_markt_category_id" => 160,
            ],

            [
                "id" => 10,
                "name" => "Elektrik Steuergerät Automatikgetr",
                "code" => null,
                "autoteile_markt_category_id" => 535,
            ],

            [
                "id" => 11,
                "name" => "Lenkung Servolenkung Lenkgetrie",
                "code" => null,
                "autoteile_markt_category_id" => 858,
            ],
        ];

        foreach($germanPartTypes as $germanPartType) {
            $partType = GermanCarPartType::where('id', $germanPartType['id']);

            $partType->update([
                'autoteile_markt_category_id' => $germanPartType['autoteile_markt_category_id'],
            ]);
        }

        DB::table('german_car_part_types')->insert($germanPartTypes);

        $carPartTypes = CarPartType::all();

        CarPartType::find(1)->germanCarPartTypes()->syncWithoutDetaching([1]);
        CarPartType::find(2)->germanCarPartTypes()->syncWithoutDetaching([2]);
        CarPartType::find(3)->germanCarPartTypes()->syncWithoutDetaching([3]);
        CarPartType::find(4)->germanCarPartTypes()->syncWithoutDetaching([4]);
        CarPartType::find(5)->germanCarPartTypes()->syncWithoutDetaching([5]);
        CarPartType::find(6)->germanCarPartTypes()->syncWithoutDetaching([6]);
        CarPartType::find(7)->germanCarPartTypes()->syncWithoutDetaching([7]);

        CarPartType::find(8)->germanCarPartTypes()->syncWithoutDetaching([8]);
        CarPartType::find(9)->germanCarPartTypes()->syncWithoutDetaching([8]);
        CarPartType::find(10)->germanCarPartTypes()->syncWithoutDetaching([9]);
        CarPartType::find(11)->germanCarPartTypes()->syncWithoutDetaching([10]);
        CarPartType::find(12)->germanCarPartTypes()->syncWithoutDetaching([11]);

        foreach ($carPartTypes as $carPartType) {
            if(DanishCarPartType::find($carPartType->id)) {
                $carPartType->danishCarPartTypes()->attach($carPartType->id);
            }
        }

        $swedishPartTypes = [
            ["id" => 1, "name" => "MOTOR BENSIN", "code" => "7201"], // 1 in danish
            ["id" => 2, "name" => "MOTOR DIESEL", "code" => "7280"], // 1 in danish
            ["id" => 3, "name" => "VÄXEL FÖRDELNINGSLÅDA", "code" => "7704"], // 2 in danish
            ["id" => 4, "name" => "VÄXELLÅDA TRONIC", "code" => "7700"], // 3 in danish
            ["id" => 5, "name" => "VÄXELLÅDA AUTOMAT", "code" => "7705"], // 3 in danish
            ["id" => 6, "name" => "VÄXELLÅDA MAN. 6 VXL", "code" => "7706"], // 4 in danish
            ["id" => 7, "name" => "AVGAS PARTIKELFILTER", "code" => "7868"], // 5
            ["id" => 8, "name" => "KATALYSATOR", "code" => "7860"], // 6
            ["id" => 9, "name" => "FRAMVAGN DIFFRENTIAL", "code" => "7070"], // 7
            ["id" => 10, "name" => "BAKVÄXEL/DIFF.", "code" => "7145"], // 7
            ["id" => 11, "name" => "MOTOR ELEKTRISK BAK", "code" => "7143"],
            ["id" => 12, "name" => "MOTOR ELEKTRISK FRAM", "code" => "7302"],

            // New..
            ['id' => 13, 'name' => 'Styrenhet ABS', 'code' => '7475'],
            ['id' => 14, 'name' => 'ABS hydraulaggerat', 'code' => '7645'],
            ['id' => 15, 'name' => 'Instrument Komb', 'code' => '3220'],
            ['id' => 16, 'name' => 'STYRENHET VÄXELLÅDA ', 'code' => '7468'],
            ['id' => 17, 'name' => 'STYRSERVOPUMP ELEKTRISK', 'code' => '7082'],
        ];

        DB::table('swedish_car_part_types')->insert($swedishPartTypes);

        CarPartType::find(1)->swedishCarPartTypes()->syncWithoutDetaching([1, 2, 11, 12]);
        CarPartType::find(2)->swedishCarPartTypes()->syncWithoutDetaching([3]);
        CarPartType::find(3)->swedishCarPartTypes()->syncWithoutDetaching([4, 5]);
        CarPartType::find(4)->swedishCarPartTypes()->syncWithoutDetaching([6]);
        CarPartType::find(5)->swedishCarPartTypes()->syncWithoutDetaching([7]);
        CarPartType::find(6)->swedishCarPartTypes()->syncWithoutDetaching([8]);
        CarPartType::find(7)->swedishCarPartTypes()->syncWithoutDetaching([9, 10]);

        // TODO new types
        CarPartType::find(8)->swedishCarPartTypes()->syncWithoutDetaching([13]);
        CarPartType::find(9)->swedishCarPartTypes()->syncWithoutDetaching([14]);
        CarPartType::find(10)->swedishCarPartTypes()->syncWithoutDetaching([15]);
        CarPartType::find(11)->swedishCarPartTypes()->syncWithoutDetaching([16]);
        CarPartType::find(12)->swedishCarPartTypes()->syncWithoutDetaching([17]);
    }
}
