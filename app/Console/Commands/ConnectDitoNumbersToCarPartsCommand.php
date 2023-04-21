<?php

namespace App\Console\Commands;

use App\Models\CarPart;
use App\Models\DitoNumber;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ConnectDitoNumbersToCarPartsCommand extends Command
{
    protected $signature = 'connect:dito:numbers';

    protected $description = 'Command description';

    public function handle()
    {
        $carParts = CarPart::all();

        foreach($carParts as $carPart) {
             $id = optional(DitoNumber::where('dito_number', $carPart->dito_number_id)
                ->first())
                ->id;

             if($id) {
                 $carPart->dito_number_id = $id;
                 $carPart->save();
             }
        }

        return CommandAlias::SUCCESS;
    }
}
