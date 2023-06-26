<?php

namespace App\Console\Commands;

use App\Models\CarPartType;
use App\Models\NewCarPart;
use App\Models\SwedishCarPartType;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FenixResolveFieldsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fenix:resolve-fields';

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
        $carParts = NewCarPart::all();

        foreach($carParts as $carPart) {
            $carPartTypeId = SwedishCarPartType::where('code', $carPart->sbr_part_code)
                ->first()
                ->carPartTypes
                ->first()
                ->id;

            $carPart->article_nr = \Str::random(24);
            $carPart->car_part_type_id = $carPartTypeId;
            $carPart->save();

            //$carPart->car_part_type_id = $carPart->
        }

        return Command::SUCCESS;
    }
}
