<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EngineType;
use Illuminate\Support\Facades\File;

class EngineTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = File::get(base_path() . '/database/data/engine-types.json');

        $data = json_decode($file, true);

        EngineType::insert($data);
    }
}
