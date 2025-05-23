<?php

namespace App\Console\Commands\Fenix;

use App\Models\NewCarPart;
use App\Services\PartInformationService;
use Illuminate\Console\Command;


/*
 * Generate a name for sales platform based on the part information
 */
class AddSellingNameToPartsCommand extends Command
{
    protected $signature = 'fenix:resolve-name';

    private PartInformationService $service;

    public function __construct()
    {
        parent::__construct();

        $this->service = new PartInformationService();
    }

    public function handle(): int
    {
        $parts = NewCarPart::whereNotNull('car_part_type_id')
            ->get();

        foreach ($parts as $part) {
            $part->name = $this->service->getNameForEbay($part);

            $part->save();
        }

        return Command::SUCCESS;
    }
}
