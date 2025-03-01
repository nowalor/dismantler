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
        // Retrieve all car part types where slug is NULL or empty
        $carPartTypes = DB::table('car_part_types')
            ->whereNull('slug') // Ensure slug is missing
            ->orWhere('slug', '') // Ensure slug is an empty string
            ->get();

        // Iterate over each car part type and update only if slug is missing
        foreach ($carPartTypes as $carPartType) {
            DB::table('car_part_types')
                ->where('id', $carPartType->id)
                ->update([
                    'slug' => Str::slug($carPartType->name)
                ]);
        }

        // Output a message in the console for debugging
        $this->command->info('Slugs updated successfully for missing entries.');
    }
}
