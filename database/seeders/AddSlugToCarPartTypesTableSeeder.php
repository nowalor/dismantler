<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
            ->whereNull('slug')
            ->orWhere('slug', '')
            ->get();

        // Iterate over each car part type
        foreach ($carPartTypes as $carPartType) {
            $slug = Str::slug($carPartType->name);

            // Check if this slug already exists in the table
            $existingSlug = DB::table('car_part_types')
                ->where('slug', $slug)
                ->exists();

            if (!$existingSlug) {
                // Update the record only if the slug is unique
                DB::table('car_part_types')
                    ->where('id', $carPartType->id)
                    ->update(['slug' => $slug]);

                $this->command->info("Slug '{$slug}' added for ID {$carPartType->id}");
            } else {
                $this->command->warn("Skipping ID {$carPartType->id} - Slug '{$slug}' already exists.");
            }
        }

        $this->command->info('Slug seeding completed.');
    }
}
