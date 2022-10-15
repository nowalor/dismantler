<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            [
                'name' => 'Denmark',
                'iso' => 'DKK',
            ],
            [
                'name' => 'Germany',
                'iso' => 'DE',
            ],
            [
                'name' => 'Sweden',
                'iso' => 'SE',
            ],
        ];

        Country::insert($countries);
    }
}
