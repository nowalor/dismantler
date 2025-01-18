<?php

namespace Database\Seeders;

use App\Models\KType;
use Database\Seeders\old\CarPartSeeder;
use Illuminate\Database\Seeder;

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
            DataProviderSeeder::class,
            PaymentPlatformSeeder::class,
            NewCarPartTypeSeeder::class,

            CarBrandSeeder::class, // Needs to be before DitoNumberSeeder


            KbaSeeder::class,
            KTypeSeeder::class,
            DitoNumberSeeder::class,
            DitoNumberKbaSeeder::class,

            EngineTypeSeeder::class,
            EngineTypeGermanDismantlerSeeder::class,

            SbrCodeSeeder::class,
            DitoNumberSbrCodeSeeder::class


//            EngineTypeSeeder::class,
//            EngineTypeGermanDismantlerSeeder::class,
//            DismantleCompanySeeder::class,
////            CarPartSeeder::class,
        ]);
//        \Artisan::call('k-type:find-kba'); // Find k-type -> kba connections

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

    }
}
