<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataProviderSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'name' => 'Fenix',
            'api_url' => config('services.fenix_api.base_uri'),
            'country' => 'Sweden',
        ];

        DB::table('data_providers')->insert($data);
    }
}
