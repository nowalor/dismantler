<?php

namespace App\Console\Commands;

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

            $part->new_name = $name;
            $part->save();
        }

        return Command::SUCCESS;
    }

    private function parts(): Collection
    {
        return NewCarPart::whereNotNull('car_part_type_id')->whereNotNull('sbr_car_name')->get();

//        return NewCarPart::where('car_part_type_id', 1)
//            ->
//            ->get();
    }
}
