<?php

namespace App\Console\Commands;

use App\Models\CarPart;
use App\Models\EngineType;
use App\Models\GermanDismantler;
use Illuminate\Console\Command;

class ConnectKbaToDitoThroughEngineTypesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test-connect-kba-to-dito';

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

        $carParts = CarPart::whereHas('ditoNumber')->get();

        foreach ($carParts as $carPart) {
            $dismantlers = $carPart->ditoNumber->germanDismantlers;

            foreach ($dismantlers as $dismantler) {
                $commercialName = $dismantler->commercial_name;

                $affectedKba = GermanDismantler::where('commercial_name', 'like', "%$commercialName%")->get();

                foreach($affectedKba as $kba) {
                    $kba->ditoNumbers()->syncWithoutDetaching($carPart->dito_number_id);
                }
            }
        }

    }
}
