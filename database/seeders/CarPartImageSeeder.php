<?php

namespace Database\Seeders;

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
        Log::info(json_decode($file, true));
        CarPartImage::insert(json_decode($file, true));
    }
}
