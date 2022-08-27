<?php

namespace Database\Seeders;

use App\Models\DismantleCompany;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\View\Engines\EngineResolver;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ManufacturerPlaintextSeeder::class,
            CommericalNameSeeder::class,
            KbaSeeder::class,
            DitoNumberSeeder::class,
            DitoNumberKbaSeeder::class,
            EngineTypeSeeder::class,
            EngineTypeGermanDismantlerSeeder::class,
            DismantleCompanySeeder::class,
            CarPartTypeSeeder::class,
            CarPartSeeder::class,
            CarPartImageSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

    }
}
