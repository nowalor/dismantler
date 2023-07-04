<?php

namespace Database\Seeders;

use App\Models\EngineType;
use App\Models\GermanDismantler;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;


class NewEngineTypeGermanDismantlerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = File::get(base_path() . '/database/data/new-engine-connections.json');

        $data = json_decode($file, true, 512, JSON_THROW_ON_ERROR);

        foreach ($data as $engineType) {
            $engineTypeDB = EngineType::where('name', [$engineType['name']])->first();

            $germanDismantlerIds = [];

            foreach ($engineType['kba_numbers'] as $kba) {
                $germanDismantler = GermanDismantler::where('hsn', $kba['hsn'])->where('tsn', $kba['tsn'])->first();

                if ($germanDismantler) {
                    $germanDismantlerIds[] = $germanDismantler->id;
                }
            }

            $engineTypeDB->germanDismantlers()->syncWithoutDetaching($germanDismantlerIds);
        }
    }
}
