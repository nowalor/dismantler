<?php

namespace Database\Seeders;

use App\Models\CarPartType;
use Illuminate\Database\Seeder;

class AddGermanNameToCarPartTypesSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id' => 3574,
                'name' => "MOTOR",
                'german_name' => "Motor",
                'code' => "0010",
            ],
            [
                'id' => 3616,
                'name' => "PARTIKELFILTER",
                'german_name' => "Partikelfilter",
                'code' => "1284",
            ],
            [
                'id' => 3617,
                'name' => "KATALYSATOR",
                'german_name' => "Katalysator",
                'code' => "1285",
            ],
            [
                'id' => 3744,
                'name' => "FORDELERGEARKASSE",
                'german_name' => "Automatikgetriebe",
                'code' => "2020",
            ],
            [
                'id' => 3746,
                'name' => "GEARKASSE  AUTOMATIC",
                'german_name' => "Automatikgetriebe",
                'code' => "2022",
            ],
            [
                'id' => 3749,
                'name' => "GEARKASSE 6 GEAR",
                'german_name' => "Schaltgetriebe 6-Gang",
                'code' => "2026",
            ],
            [
                'id' => 3812,
                'name' => "BAGTØJSKLUMP",
                'german_name' => "Differential",
                'code' => "2601",
            ],
        ];

        foreach($data as $item) {
            CarPartType::find($item['id'])->update([
                'german_name' => $item['german_name']
            ]);
        }
    }
}
