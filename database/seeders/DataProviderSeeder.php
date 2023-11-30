<?php

namespace Database\Seeders;


use App\Enums\DataProviderEnum;
use App\Models\DataProvider;
use Illuminate\Database\Seeder;

class DataProviderSeeder extends Seeder
{
    public function run()
    {
        DataProvider::insertOrIgnore([
            [
                'id' => DataProviderEnum::Fenix->value,
                'name' => 'Fenix',
                'api_url' => config('services.fenix_api.base_uri'),
                'country' => 'Sweden',
            ],
            [
                'id' => DataProviderEnum::Nemdele->value,
                'name' => 'Nemdele',
                'api_url' => 'TODO',
                'country' => 'Denmark',
            ]
        ]);
    }
}
