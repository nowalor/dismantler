<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class FenixImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fenix_part_imports')->insert([
            'last_dismantler' => null,
            'from_date' => Carbon::now()->subWeek()->startOfHour(),
            'to_date' => Carbon::now()->startOfHour(),
        ]);
    }
}
