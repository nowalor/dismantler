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
        $file = File::get(base_path() . '/database/data/kfz/newest.json');

        $data = json_decode($file, true);

        foreach ($data as $kba) {
            $germanDismantler = GermanDismantler::find($kba['id']);

            if(is_null($germanDismantler->full_name)) {
                $germanDismantler->full_name = $kba['full_name'];
                $germanDismantler->construction_year = $kba['construction_year'];
                $germanDismantler->updated_at = now();

                $germanDismantler->save();
            }
        }
    }
}
