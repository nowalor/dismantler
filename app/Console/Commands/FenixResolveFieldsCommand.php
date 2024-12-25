<?php

namespace App\Console\Commands;

use App\Models\CarPart;
use App\Models\CarPartType;
use App\Models\DanishCarPartType;
use App\Models\DitoNumber;
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
//        $carParts = NewCarPart::whereIn('sbr_part_code', ['7475', '7645', '3220', '7468', '7082'])
//            ->whereNull('car_part_type_id')
//            ->get();


        $carParts = NewCarPart::whereIn('sbr_part_code', [
            "7201",
            "7280",
            "7704",
            "7705",
            "7706",
            "7868",
            "7860",
            "7070",
            "7145",
            "7143",
            "7302",
            "7816",
            "3230",
            "7255",
            "7295",
            "7393",
            "7411",
            "7700",
            "7835",
            "3135",
            "1020",
            "1021",
            "1022",
            "4638",
            "3235",
            "3245",
            "4573",
            "7050",
            "7051",
            "7052",
            "7070",
            "7475",
            "7645",
            "3220",
            "7468",
            "7082",
            "4626",
            "7470",
            "7487"
        ])
            ->whereNull('article_nr')
        ->get();

        foreach($carParts as $carPart) {
            if($carPart->country === 'DK') {
                $carPartTypeId = DanishCarPartType::where('code', $carPart->dito_number)
                    ->first()
                    ?->carPartTypes
                    ?->first()
                    ?->id;

                $carPart->car_part_type_id = $carPartTypeId;
                $carPart->save();
            } else {
                $carPartTypeId = SwedishCarPartType::where('code', $carPart->sbr_part_code)
                    ->first()
                    ?->carPartTypes
                    ?->first()
                    ?->id;

                if(!$carPartTypeId) {
                    $this->info("Failed, $carPart->sbr_part_code");
                    exit;
                }
            }

            $sbrCode = SbrCode::where('sbr_code', $carPart->sbr_car_code)->first();

            // Has been extracted to "FindDitoNumberFromDanishpartCode.."
            $ditoNumberCarCode = substr($carPart->danish_item_code, 0, 4);
            $ditoNumber = DitoNumber::where('dito_number', $ditoNumberCarCode)->first();

            if($sbrCode){
                $carPart->sbr_code_id  = $sbrCode->id;
            } else if($ditoNumber) {
                $sbrCode = $ditoNumber->sbrCodes()->first(); // Should have special cases when one dito maps to 2x sbr codes?

                if($sbrCode) {
                    logger($sbrCode);
                    $carPart->sbr_car_code = $sbrCode->sbr_code;
                    $carPart->sbr_car_name = $sbrCode->name;
                    $carPart->sbr_code_id = $sbrCode->id;

                    $carPart->save();
                }
            }

            if($ditoNumber) {
                $carPart->dito_number_id = $ditoNumber->id;
            }


            $articleNr = $this->generateArticleNr($carPart);

            $carPart->article_nr = $articleNr;
            if(NewCarPart::where('article_nr', $carPart->article_nr)->exists()) {
                continue; // TODO... handle these weird parts
            }

            $carPart->car_part_type_id = $carPartTypeId;

//            $carPart->name = $this->generatePartName($carPart);

            $carPart->save();

            //$carPart->car_part_type_id = $carPart->
        }

        return Command::SUCCESS;
    }

    private function generateArticleNr(NewCarPart $carPart): string
    {
        $articleNr = "{$carPart->country}{$carPart->dismantle_company_name}{$carPart->article_nr_at_dismantler}";

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
