<?php

namespace Database\Seeders;

use App\Models\EngineType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class NewEngineTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = File::get(base_path() . '/database/data/new-engines.json');

        $data = json_decode($file, true);

        foreach($data as $engineType) {
            EngineType::firstOrcreate([
                'name' => $engineType['name'],
            ]);
        }
    }
}
