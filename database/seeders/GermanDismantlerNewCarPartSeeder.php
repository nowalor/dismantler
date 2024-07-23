<?php

namespace Database\Seeders;

use App\Models\NewCarPart;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GermanDismantlerNewCarPartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NewCarPart::with('sbrCode.ditoNumbers.germanDismantlers')
            ->chunk(100, function ($newCarParts) {
                $newCarParts->each(function (NewCarPart $part) {
                    foreach ($part->_my_kba as $kba) {
                        $part->germanDismantlers()->syncWithoutDetaching([$kba->id]);
                    }
                });
            });
    }

}
