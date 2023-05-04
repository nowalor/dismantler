<?php

namespace Database\Seeders;

use App\Models\GermanDismantler;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SeedFullNameAndConstructionYearForAudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = File::get(base_path() . '/database/data/kfz/seat.json');

        $data = json_decode($file, true);

        foreach($data as $kba) {
            $germanDismantler= GermanDismantler::find($kba['id']);

            $germanDismantler->full_name = $kba['full_name'];
            $germanDismantler->construction_year = $kba['construction_year'];

            $germanDismantler->save();
        }

        $file = File::get(base_path() . '/database/data/kfz/skoda.json');

        $data = json_decode($file, true);

        foreach($data as $kba) {
            $germanDismantler= GermanDismantler::find($kba['id']);

            $germanDismantler->full_name = $kba['full_name'];
            $germanDismantler->construction_year = $kba['construction_year'];

            $germanDismantler->save();
        }
    }
}
