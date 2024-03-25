<?php

namespace Database\Seeders;

use App\Models\GermanDismantler;
use Database\Data\New\GermanDismantlerData;
use Illuminate\Database\Seeder;

class KbaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kbas = GermanDismantlerData::DATA;

        foreach($kbas as $kba) {
            GermanDismantler::create($kba);
        }
    }
}
