<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NewCarPart;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FenixTestPartSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $chunkSize = 10000;
        $target = 1000000;

        $this->command->warn('🚨 Deleting old dummy data...');
        NewCarPart::where('country', 'dummy')->delete();

        $this->command->info("🚀 Starting to seed {$target} dummy parts...");

        for ($i = 0; $i < ($target / $chunkSize); $i++) {
            $this->command->info("⏳ Seeding batch " . ($i + 1));

            $timestamp = now();
            $parts = [];

            for ($j = 0; $j < $chunkSize; $j++) {
                $parts[] = [
                    'original_id' => Str::uuid()->toString(),
                    'price_sek' => round($faker->randomFloat(2, 100, 10000), 2),
                    'data_provider_id' => 1,
                    'country' => 'dummy',

                    'sbr_part_code' => $faker->numerify('####'),
                    'sbr_car_code' => $faker->numerify('####'),
                    'original_number' => substr(strtoupper($faker->bothify('??###')), 0, 20),
                    'quality' => $faker->randomElement(['A', 'B', 'C']),
                    'engine_code' => substr(strtoupper($faker->bothify('ENG###')), 0, 20),
                    'engine_type' => $faker->randomElement(['Diesel', 'Petrol', 'Electric', 'Hybrid']),
                    'fuel' => $faker->randomElement(['Diesel', 'Petrol', 'Electric']),
                    'gearbox' => $faker->randomElement(['Manual', 'Auto']),
                    'warranty' => (string) $faker->randomElement(['0', '3', '6', '12']),
                    'vin' => substr(strtoupper($faker->bothify('??##############')), 0, 30),
                    'model_year' => (string) $faker->year,

                    'sbr_car_name' => substr($faker->words(2, true), 0, 50),
                    'body_name' => substr($faker->word, 0, 50),
                    'dismantle_company_name' => app()->environment('local')
                        ? substr($faker->company ?: 'UNKNOWN', 0, 50)
                        : substr($faker->company, 0, 50),
                    'article_nr_at_dismantler' => substr(strtoupper($faker->bothify('ART-#####')), 0, 30),

                    'mileage_km' => $faker->numberBetween(1000, 250000),
                    'mileage' => $faker->numberBetween(100, 25000),

                    'quantity' => 1,
                    'is_live' => 1,
                    'is_live_on_ebay' => 0,
                    'is_live_on_hood' => 0,

                    'dismantled_at' => now()->subDays(rand(0, 365)),
                    'originally_created_at' => now()->subDays(rand(366, 730)),
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            }

            try {
                NewCarPart::insert($parts);
            } catch (\Throwable $e) {
                $this->command->error("Insert failed in batch {$i}: " . $e->getMessage());
                break;
            }
        }

        $this->command->info("Done seeding {$target} parts.");
    }
}
