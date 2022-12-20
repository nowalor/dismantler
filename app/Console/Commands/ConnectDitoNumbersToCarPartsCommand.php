<?php

namespace App\Console\Commands;

use App\Models\CarPart;
use App\Models\DitoNumber;
use Illuminate\Console\Command;

class ConnectDitoNumbersToCarPartsCommand extends Command
{
    protected $signature = 'connect:dito:numbers';

    protected $description = 'Command description';

    public function handle()
    {
        /* $ditoNumbers = DitoNumber::all();

        foreach($ditoNumbers as $ditoNumber) {
            CarPart::where('name_for_search', 'like', "%$ditoNumber->new_name%")
                ->update(['dito_number_id' => $ditoNumber->id]);
        } */

        $carParts = CarPart::all();

        foreach($carParts as $carPart) {
             $id = optional(DitoNumber::where('dito_number', $carPart->dito_number_from_item_code)
                ->first())
                ->id;

             if($id) {
                 $carPart->dito_number_id = $id;
                 $carPart->save();
             }
        }

        return Command::SUCCESS;
    }
}
