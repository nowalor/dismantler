<?php

namespace App\Console\Commands;

use App\Models\NewCarPart;
use App\Services\PartInformationService;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class CreateDescriptionNameCommand extends Command
{
    protected $signature = 'ebay:make-description-name';

    public function __construct(private PartInformationService $partInformationService)
    {
        parent::__construct();
    }


    public function handle(): int
    {
        $parts = $this->parts();

        foreach($parts as $part) {
            $name = $this->partInformationService->getDescriptionName($part);

            $part->description_name = $name;
            $part->save();
        }

        return Command::SUCCESS;
    }

    private function parts(): Collection
    {
        return NewCarPart::whereNotNull('car_part_type_id')->whereNotNull('sbr_car_name')->get();
    }
}
