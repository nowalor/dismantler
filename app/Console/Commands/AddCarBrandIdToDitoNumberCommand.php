<?php

namespace App\Console\Commands;

use App\Models\CarBrand;
use App\Models\DitoNumber;
use Illuminate\Console\Command;

class AddCarBrandIdToDitoNumberCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dito-number:add-car-brand-id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ditoNumbers = DitoNumber::all();

        foreach ($ditoNumbers as $ditoNumber) {
            $ditoNumber->car_brand_id = CarBrand::firstWhere('name', $ditoNumber->producer)->id;
            $ditoNumber->save();
        }

        return Command::SUCCESS;
    }
}
