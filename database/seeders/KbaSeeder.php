<?php

namespace Database\Seeders;

use App\Data\GermanDismantlerData;
use App\Models\GermanDismantler;
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
            GermanDismantler::firstOrCreate(['id' => $kba['id'], 'hsn' => $kba['hsn'], 'tsn' => $kba['tsn']], $kba);
        }
    }
}
