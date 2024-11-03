<?php

namespace App\Console\Commands;

use App\Models\CarPart;
use App\Models\NewCarPart;
use App\Services\PartInformationService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class AddNewNameToPartsCommand extends Command
{

    protected $signature = 'parts:add-new-name';

    public function __construct(private PartInformationService $partInformationService)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $parts = $this->parts();

        foreach($parts as $part) {
            $name = $this->partInformationService->getNameForEbay($part);
            $this->info("name: $name");

            $part->new_name = $name;
            $part->save();
        }

        return Command::SUCCESS;
    }

    private function parts(): Collection
    {
        return NewCarPart::
     /*   whereNotNull('sbr_car_name')*/
         /*   where('article_nr', 'AL1053908')*/
        whereIn('sbr_part_code', [
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
            ->get();
       // whereNotNull('car_part_type_id')
            //->whereNotNull('dito_number')
     //    ->// Only relavant for fenix and not egluit?
           // ->all();


//        return NewCarPart::where('id', 15674962491)->get();

//        return NewCarPart::where('car_part_type_id', 1)
//            ->
//            ->get();
    }
}
