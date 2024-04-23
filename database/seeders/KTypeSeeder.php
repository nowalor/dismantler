<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KType;
use Illuminate\Support\Facades\File;

class KTypeSeeder extends Seeder
{
    public function run()
    {
        $file = File::get(base_path() . '/database/data/k-types.json');

        $data = json_decode($file, true);

        foreach(array_chunk($data, 500) as $kTypes) {
            KType::insert($kTypes);
        }

//        foreach ($data as $row) {
//            // Adjust the column names based on your Excel file
//            KType::create([
//                'k_type' => $row->k_type,
//                'brand' => $row->brand,
//                'model' => $row->model,
//                'type' => $row->type,
//                'platform' => $row->platform,
//                'production_period' => $row->production_period,
//                'engine_information' => $row->engine_info,
//                'kba_string' => $row->kba_string,
//                'number_of_years_in_construction' => $row->number_of_years_in_construction,
//                // Add more columns as needed
//            ]);
//        }
    }
}
