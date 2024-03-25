<?php

namespace Database\Seeders;

use App\Data\DitoNumberData;
use App\Models\DitoNumber;
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
            $ditoNumber['created_at'] = now();
            DitoNumber::firstOrCreate(['id' => $ditoNumber['id'], 'dito_number' => $ditoNumber['dito_number']], $ditoNumber);
        }
    }

}
