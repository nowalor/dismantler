<?php

namespace App\Console\Commands;

use App\Models\CarPartType;
use App\Models\NewCarPart;
use App\Models\SbrCode;
use App\Models\SwedishCarPartType;
use App\Services\PartInformationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FenixResolveFieldsCommand extends Command
{
    public function __construct(private PartInformationService $partInformationService)
    {
        parent::__construct();
    }

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
        $carParts = NewCarPart::whereIn('sbr_part_code', ['7475', '7645', '3220', '7468', '7082'])
            ->whereNull('car_part_type_id')
            ->get();

        foreach($carParts as $carPart) {
            $carPartTypeId = SwedishCarPartType::where('code', $carPart->sbr_part_code)
                ->first()
                ->carPartTypes
                ->first()
                ->id;

            $sbrCode = SbrCode::where('sbr_code', $carPart->sbr_car_code)->first();

            if(!$sbrCode) {
                logger("SbrCode not found for car part id: $carPart->id");
                continue;
            }
            $sbrCodeId = $sbrCode->id;

            $carPart->article_nr = $this->generateArticleNr($carPart);
            $carPart->car_part_type_id = $carPartTypeId;
            $carPart->name = $this->generatePartName($carPart);
            $carPart->sbr_code_id = $sbrCodeId;

            $carPart->save();

            //$carPart->car_part_type_id = $carPart->
        }

        return Command::SUCCESS;
    }

    private function generateArticleNr(NewCarPart $carPart): string
    {
        $articleNr = "{$carPart->dismantle_company_name}{$carPart->article_nr_at_dismantler}";

        return $articleNr;
    }

    // Return PartName - Vehicle - Engine Code - Original number
    private function generatePartName(NewCarPart $carPart): string
    {
        $carPartTypeId = $carPart->car_part_type_id;
        $carPartTypeNameGerman = CarPartType::find($carPartTypeId)->germanCarPartTypes()->first()->name;

        if($carPartTypeNameGerman === 'Motor' || (!$carPart->subgroup && !$carPart->gearbox_nr)) {
            $additionalInformation = $carPart->engine_code;
        } else if(!isset($additionalInformation)) {
            $additionalInformation = $this->partInformationService->getGearbox($carPart);
        }

        $name =
            "$carPartTypeNameGerman / $carPart->sbr_car_name / $additionalInformation / $carPart->original_number";

        return $name;
    }
}
