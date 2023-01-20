<?php

namespace Database\Seeders;

use App\Models\CarPart;
use App\Models\EngineType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeedEngineTypesFromCarPartsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $uniqueEngineCodesFromCarParts = CarPart::select('engine_code')
            ->where('engine_code', '!=', '')
            ->distinct()
            ->get()
            ->pluck('engine_code')
            ->toArray();

        $engineTypesFromDB = EngineType::select('name')
            ->distinct()
            ->get()
            ->pluck('name')
            ->toArray();

        // Create an array with all the uniqueEngineCodesFromCarParts that don't exist in engineTypesFromDb
        $missingEngineTypes = array_diff($uniqueEngineCodesFromCarParts, $engineTypesFromDB);

        foreach ($missingEngineTypes as $engineType) {
            EngineType::create([
                'name' => $engineType,
            ]);
        }
    }
}
