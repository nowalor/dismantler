<?php

namespace Database\Seeders;

use App\Models\DitoNumber;
use Database\Data\New\DitoNumberData;
use Illuminate\Database\Seeder;

class DitoNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ditoNumbers = DitoNumberData::DATA;

        foreach($ditoNumbers as $ditoNumber) {
            DitoNumber::create($ditoNumber);
        }
    }

}
