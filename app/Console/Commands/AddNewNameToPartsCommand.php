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
            if($part->sbr_part_code == "7393") {
                continue; // TODO
            }

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
            "4626", // screens
            "7470",
            "7487",
            "7816",
            "3230",
            "7255",
            "7295",
            /*   "7393",*/
            "7411",
            "7700",
            "7835",
        ])
            ->orWhere('dismantle_company_name', 'h')
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
