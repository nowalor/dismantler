<?php

namespace Database\Seeders;

use App\Models\MotorType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class MotorTypeSeeder extends Seeder
{
    public function run(): void
    {
        $file = File::get(base_path() . '/database/data/motor-types.json');

        $data = json_decode($file, true);

        foreach($data as $motorType) {
            MotorType::firstOrCreate([
                'name' => $motorType['name']
            ]);
        }
    }
}
