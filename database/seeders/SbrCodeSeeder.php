<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SbrCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = File::get("database/data/sbr-codes.json");
        $data = json_decode($file, true);

        foreach ($data as $obj) {
            \App\Models\SbrCode::create($obj);
        }
    }
}
