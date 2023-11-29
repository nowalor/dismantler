<?php

namespace Database\Seeders;

use App\Enums\DataProviderEnum;
use App\Models\DataProvider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataProviderSeeder extends Seeder
{
    public function run()
    {
        DataProvider::insertOrIgnore([
            [
                'id' => DataProviderEnum::Fenix->value,
                'name' => 'Fenix',
                'api_url' => 'https://fenixapi-integration.bosab.se/api',
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
