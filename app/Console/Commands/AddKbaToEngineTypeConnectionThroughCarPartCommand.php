<?php

namespace App\Console\Commands;

use App\Models\CarPart;
use Illuminate\Console\Command;

class AddKbaToEngineTypeConnectionThroughCarPartCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'engine_to_kba:through_car_part';

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
        $carParts = CarPart::whereNotNull('engine_type_id')
            ->whereNotNull('dito_number_id')
            ->has('ditoNumber.germanDismantlers')
            ->with('ditoNumber.germanDismantlers')
            ->get();

        foreach($carParts as $carPart) {
            // Go through $carPart->ditoNumber->germanDismantlers and save a connection between the engine type and the german dismantler
            foreach($carPart->ditoNumber->germanDismantlers as $germanDismantler) {
                $germanDismantler->engineTypes()->syncWithoutDetaching($carPart->engine_type_id);
            }
        }

        return Command::SUCCESS;
    }
}
