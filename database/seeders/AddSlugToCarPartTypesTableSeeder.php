<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Import the Str helper

class AddSlugToCarPartTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve all car part types
        $carPartTypes = DB::table('car_part_types')->get();

        // Iterate over each car part type and update its slug
        foreach ($carPartTypes as $carPartType) {
            DB::table('car_part_types')
                ->where('id', $carPartType->id)
                ->update([
                    'slug' => Str::slug($carPartType->name)
                ]);
        }
    }
}
