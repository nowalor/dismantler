<?php

namespace Database\Seeders;

use App\Models\GermanDismantler;
use App\Models\MotorType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class MotorTypeGermanDismantlerSeeder extends Seeder
{
    public function run(): void
    {
        $file = File::get(base_path() . '/database/data/kfz-volvo-dump.json');

        $data = json_decode($file, true);

        foreach ($data as $kba) {
            $motorTypeNames = MotorType::whereIn('name', array_values($kba['motor_types']))->pluck('id');

            $kbaFromDB = GermanDismantler::find($kba['id']);

            $kbaFromDB->motorTypes()->syncWithoutDetaching($motorTypeNames);
        }
    }
}
