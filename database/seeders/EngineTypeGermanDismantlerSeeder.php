<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EngineType;
use App\Models\GermanDismantler;
use App\Models\EngineTypeGermanDismantler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;



class EngineTypeGermanDismantlerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $file = File::get(base_path() . '/database/data/engine-type-connections.json');
//
//        $data = json_decode($file, true, 512, JSON_THROW_ON_ERROR);
//
//        foreach($data as $kba) {
//            $engineTypeIds = EngineType::whereIn('name', array_values($kba['engine_types']))->pluck('id');
//
//        $kbaFromDB = GermanDismantler::find($kba['id']);
//
//        $kbaFromDB->engineTypes()->syncWithoutDetaching($engineTypeIds);
//        }

        $file = File::get(base_path() . '/database/data/engine-type-german-dismantler.json');
        $data = json_decode($file, true, 512, JSON_THROW_ON_ERROR);

        DB::table('engine_type_german_dismantler')->insert($data);

    }
}
