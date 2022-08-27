<?php

namespace Database\Seeders;

use App\Models\CarPart;
use App\Models\CarPartImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class CarPartImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = File::get(base_path() . '/database/data/car_parts_images.json');

        $images = json_decode($file, true);


        foreach (array_chunk($images ,1000) as $t)
        {
            CarPartImage::insert($t);
        }
    }
}
