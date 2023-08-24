<?php

namespace App\Console\Commands\AutoteileMarkt;

use App\Models\NewCarPart;
use App\Services\AutoteileMarkDocService;
use Illuminate\Console\Command;

class ExportPartsAsCsvCommand extends Command
{
    protected $signature = 'autoteile-markt:export';

    private AutoteileMarkDocService $csvService;

    public function __construct()
    {
        $this->csvService = new AutoteileMarkDocService();

        parent::__construct();
    }

    public function handle(): int
    {
        $parts = NewCarPart::has('sbrCode.ditoNumbers')
            ->where('sbr_car_name', 'like', '%audi%')->get();

        foreach ($parts as $part) {
            logger()->info($part->id);

            $this->csvService->generateExportCSV($part);

            $part->update(['is_live' => true]);
        }

        return Command::SUCCESS;
    }
}
